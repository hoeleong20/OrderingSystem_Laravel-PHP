<?php

namespace App\Http\Controllers;

use App\Models\CartItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client; // Import Guzzle HTTP Client

class CartItemController extends Controller
{
    public function sendCartItemsToJava()
    {
        // Assuming you have the XML data ready to send
        $customerID = session('customerID');
        $cartItems = CartItem::where('customerID', $customerID)->get();
    
        $xml = new \SimpleXMLElement('<cartItems/>');
        foreach ($cartItems as $item) {
            $itemNode = $xml->addChild('cartItem');
            $itemNode->addChild('id', $item->id);
            $itemNode->addChild('orderID', $item->orderID);
            $itemNode->addChild('foodName', $item->foodName);
            $itemNode->addChild('quantity', $item->quantity);
        }
    
        $client = new Client();
    
        // Send the XML data to the Java program endpoint
        $response = $client->post('http://java-program-endpoint/api/receive-cart-items', [
            'headers' => [
                'Content-Type' => 'application/xml',
            ],
            'body' => $xml->asXML() // The XML body
        ]);
    
        // Handle the response from the Java program
        if ($response->getStatusCode() == 200) {
            Log::info("Data sent successfully!");
        } else {
            Log::error("Failed to send data.");
        }
    }
    
}