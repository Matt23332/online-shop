<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
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
            'amount' => 'required|numeric',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $payment = new Payment();
        $payment->amount = $validatedData['amount'];
        $payment->payment_method = $validatedData['payment_method'];
        $payment->status = $validatedData['status'];
        $payment->save();

        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $payment = Payment::findOrFail($payment->id);
        $payment->amount = $validatedData['amount'];
        $payment->payment_method = $validatedData['payment_method'];
        $payment->status = $validatedData['status'];
        $payment->save();

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
}
