<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all orders for the authenticated user
        $orders = Auth::user()->orders;

        // Return the orders as a JSON response
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'total_price' => 'required|numeric', // Ensure total price is numeric
            'status' => 'nullable|string', // Status is optional
        ]);

        // Create the order for the authenticated user
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $request->total_price,
            'status' => $request->status ?? 'pending', // Default to 'pending' if status is not provided
        ]);

        // Return the created order as a JSON response
        return response()->json($order, 201);
    }


    /**
     * Display the specified resource.
     */
     // Get a specific order by its ID
     public function show($id)
     {
         // Find the order by ID and ensure it belongs to the authenticated user
         $order = Auth::user()->orders()->find($id);

         if (!$order) {
             return response()->json(['message' => 'Order not found'], 404);
         }

         // Return the order as a JSON response
         return response()->json($order);
     }

    /**
     * Update the specified resource in storage.
     */
     // Update the status of an existing order
     public function update(Request $request, $id)
     {
         // Validate the request to ensure 'status' is provided
         $request->validate([
             'status' => 'required|string|in:pending,processing,completed,cancelled', // Example statuses
         ]);

         // Find the order by ID for the authenticated user
         $order = Auth::user()->orders()->find($id);

         if (!$order) {
             return response()->json(['message' => 'Order not found or does not belong to the user'], 404);
         }

         // Update the order's status
         $order->status = $request->status;
         $order->save();

         // Return the updated order as a JSON response
         return response()->json($order);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
