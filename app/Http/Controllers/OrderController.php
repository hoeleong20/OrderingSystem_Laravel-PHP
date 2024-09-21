<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = CartItem::query()->orderBy('created_at','desc')->get();
        return view('order.index',['cartItems'=>$cartItems]);

        
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
        // $data=$request->validate([
        //     'note' => ['required','string']
        // ]);





        $data['orderID']='OR002';
        $data['foodItemID']='FO002';
        $data['quantity']= 1;
        $data['status']='inCart';
        
        
        $cartItems = CartItem::create($data);
        return to_route('order.show',$cartItems)->with('message','Note was create');



        
        // $data['customerId']='OR002';
        // $data['paymentTotal']= 100;
        // $data['paymentMethod']= 'FO002';
        
        // $orders = Order::create($data);
        // return to_route('order.show',$orders)->with('message','Note was create');


    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show',['order'=>$order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('order.edit',['order'=>$order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    // public function checkOut(Order $order)
    // {
    //     // return redirect()->route('order.CheckOut',['order'=>$order]);
    //     return view('order.checkOut');
    // }
}
