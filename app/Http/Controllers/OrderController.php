<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\Menu;
use App\Decorators\DecoratorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerID = session('customerID');

        $pendingOrders = Order::where('customerID', $customerID)
            ->where('status', 'pending')
            ->pluck('id')
            ->first(); // Retrieves only the first pending order ID

        if ($pendingOrders != null) { // Check if there's a pending order
            $cartItems = CartItem::where('orderID', $pendingOrders)
                ->orderBy('created_at', 'asc')
                ->get();

            session(['orderID' => $pendingOrders]);
            //Log::info('Order ID:', ['orderID' => session('orderID')]); // Log the order ID
        } else {
            session(['orderID' => 0]);
            $cartItems = collect(); // Return an empty collection
        }

        return view('order.index', ['cartItems' => $cartItems]);


        // $cartItems = CartItem::query()->orderBy('created_at','desc')->get();
        // return view('order.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //String $str
    {

        return view('order.create');


        // return view('order.create',['str'=>$str]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // If there is no active order, create a new one
        if (session('orderID') == 0) {
            $orderData['customerID'] = session('customerID');
            $orderData['paymentTotal'] = 0;
            $orderData['paymentMethod'] = 'null';
            $orderData['status'] = 'pending';

            $orders = Order::create($orderData);
            session(['orderID' => $orders->id]);
        }

        // Get menu name and base price from request
        $menuName = $request->input('menu_name');
        $menuPrice = $request->input('menu_price'); // Base price of the menu

        // Get the selected remarks from the request
        $selectedRemarks = json_decode($request->input('selected_remarks'), true);

        // Retrieve the menu instance
        $menu = new Menu($menuName, '', $menuPrice);

        // Apply the decorators for each selected remark
        foreach ($selectedRemarks as $remarkName) {
            $menu = DecoratorFactory::applyRemark($menu, $remarkName); // Apply each remark decorator
        }
        $finalPrice = $menu->getPrice();

        // Store the cart item with the final calculated price
        $data['orderID'] = session('orderID');
        $data['foodName'] = $menuName;
        $data['quantity'] = 1; // Assuming quantity is always 1 for now
        $data['foodPrice'] = $finalPrice; // Store the final price after applying decorators

        CartItem::create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('order.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $data = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        // Find the cart item and update the quantity
        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $data['quantity'];
        $cartItem->save();

        return response()->json(['message' => 'Quantity updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        // Debugging: Log the cartItem object
        // Log::info('Cart Item:', ); //storage\logs\laravel.log

        // Find the cart item and update the quantity
        $cartItem = CartItem::findOrFail($id);

        // Check if the item exists
        if ($cartItem) {
            $cartItem->delete(); // Deletes the model instance
            return response()->json(['message' => 'Item deleted successfully!']);
        } else {
            return response()->json(['message' => 'Item not found!'], 404);
        }
    }

    // public function checkout()
    // {
    //     // Assuming you have a way to get the current customer and their pending order
    //     $customerID = session('customerID');

    //     // Retrieve pending order details
    //     $order = Order::where('customerID', $customerID)
    //         ->where('status', 'pending')
    //         ->first();

    //     $cartItems = CartItem::where('orderID', $order->id)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     if ($order) {
    //         // Pass the order data to the checkout view
    //         return view('checkOut', ['order' => $order, 'cartItems' => $cartItems]);
    //     } else {
    //         // Redirect back or to another page if no pending order is found
    //         return redirect()->route('order.index')->with('error', 'No pending order found.');
    //     }
    // }

    public function checkout()
    {
        $customerID = session('customerID');

        // Retrieve pending order details
        $order = Order::where('customerID', $customerID)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $cartItems = CartItem::where('orderID', $order->id)
                ->orderBy('created_at', 'asc')
                ->get();

            // Calculate the total quantity of items
            $totalItems = $cartItems->sum('quantity');

            $totalPrice = $cartItems->sum('foodPrice');

            if ($order) {
                // Pass the order data and total items to the checkout view
                return view('checkOut', ['order' => $order, 'cartItems' => $cartItems, 'totalItems' => $totalItems, 'totalPrice' => $totalPrice]);
            } else {
                // Redirect back if no pending order is found
                return redirect()->route('order.index')->with('error', 'No pending order found.');
            }
        }
        return redirect()->route('menus.index');
    }

    public function pay(Request $request, $id)
    {
        $order = Order::findOrFail($id); // Find the order by ID

        $paymentType = $request->input('payment');
        $totalPrice = $request->input('totalPrice');

        if ($paymentType == 'ccPayment') {
            $ccPaymentType = $request->input('ccPayment');
        }

        if ($order) {
            Log::info('Updating order status for order ID: ' . $id);
            $order->paymentTotal = $totalPrice;
            $order->paymentMethod = $paymentType;
            $order->status = 'paid';
            $order->save();

            session(['orderID' => 0]);
            
            return redirect()->route('menus.index')->with('success', 'Payment successful! Order status updated to paid.');
        } else {

            Log::warning('Order not found for order ID: ' . $id);
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
}
