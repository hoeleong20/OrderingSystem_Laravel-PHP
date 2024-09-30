<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Models\CartItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class KitchenListener 
{
    public function handle(OrderUpdated $event)
    {

        Log::info('KitchenListener fired for order:', ['orderId' => $event->order->id]);

        $order = $event->order;
        // Your API and XML handling logic goes here

          
        // Check if order is completed, update related cart items
        if ($order->status === 'paid') {

            $cartItems = CartItem::where('orderID', $order->id)
                ->orderBy('created_at', 'asc')
                ->get();

            // Convert the cart items to XML format
            $xmlData = $this->convertToXml($cartItems);

            // Send the XML data to the Java program through REST API
            $this->sendXmlToJavaApi($xmlData);
            
            Log::info($xmlData);
        }
    }

    private function convertToXml($cartItems)
    {
        $xml = new \SimpleXMLElement('<CartItems/>');
        foreach ($cartItems as $item) {
            $itemNode = $xml->addChild('Item');
            $itemNode->addChild('orderID', $item['orderID']);   // Ensure you're using array keys correctly
            $itemNode->addChild('foodName', $item['foodName']);
            $itemNode->addChild('quantity', $item['quantity']);
        }
        return $xml->asXML();
    }


    private function sendXmlToJavaApi($xmlData)
    {
        $apiUrl = 'http://localhost:8080/cart-items';
        
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/xml']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        
        Log::info('xmlData:',['xmlData' => $xmlData]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            // Handle success
            Log::info('response:',['response' => $response]);
            // echo 'Response: ' . $response;
        } else {
            // Handle failure
            Log::info('Failed to send XML to Java API');
            // echo 'Failed to send XML to Java API';
        }
    }
}