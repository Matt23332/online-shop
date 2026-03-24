<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::all();
        return response()->json($orders);
    }

    //get order per user
    public function ordersPerUser($id){
        $orders= Orders::where('user_id', $id)->get();

        foreach ($orders as $order) {
            $order->product = Product::where('id', $order->product_id)->first();
        }
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);

        $order = new Orders();
        $order->user_id = $validatedData['user_id'];
        $order->product_id = $validatedData['product_id'];
        $order->quantity = $validatedData['quantity'];
        $order->total_price = $validatedData['total_price'];
        $order->status = $validatedData['status'];
        $order->save();

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        return response()->json($orders);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);

        $order = Orders::findOrFail($orders->id);
        $order->user_id = $validatedData['user_id'];
        $order->product_id = $validatedData['product_id'];
        $order->quantity = $validatedData['quantity'];
        $order->total_price = $validatedData['total_price'];
        $order->status = $validatedData['status'];
        $order->save();

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        $orders->delete();
        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
