<?php
namespace App\Observers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Http;

class OrderObserver
{
    public function created(Order $order)
    {
        // Log when a new order is created
        Log::info('Order created:', ['orderID' => $order->id, 'customerID' => $order->customerID]);
    }

    public function updated(Order $order)
    {
        // Log when an order is updated
        Log::info('Order updated:', ['orderID' => $order->id, 'status' => $order->status]);
        
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

    public function deleted(Order $order)
    {
        // Log when an order is deleted
        Log::info('Order deleted:', ['orderID' => $order->id]);
        
        // Remove all related cart items
        $order->cartItems()->delete();
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
