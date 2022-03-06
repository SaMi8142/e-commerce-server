<?php

namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class OrderController extends Controller
{
    public function createOrder(Request $request){
        
        $fields = $request->validate([
            'orders' => 'required',
            'quantity' => 'required',
            'subTotal' => 'required'
        ]);

        $user = auth()->user();

        return Order::create([
            'user_id' => $user->id,
            'orders' => $fields['orders'],
            'quantity' => $fields['quantity'],
            'subTotal' => $fields['subTotal'],
        ]);
    }

    public function getAllOrders(){
        return Order::all();
    }

    public function search($user_id)
    {
        return Order::where('user_id', $user_id)->get();
    }
}
 