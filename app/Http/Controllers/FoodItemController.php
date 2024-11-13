<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    // Show all food items
    public function index()
    {
        $foodItems = FoodItem::all();
        return response()->json($foodItems, 200);
    }

    // Show a single food item
    public function show($id)
    {
        $foodItem = FoodItem::find($id);
        if ($foodItem) {
            return response()->json($foodItem, 200);
        }
        return response()->json(['message' => 'Food item not found'], 404);
    }

    // Create a new food item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string',
            'stock' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for photo
        ]);

        // Prepare data for insertion
        $data = $request->only(['name', 'description', 'price', 'category', 'stock']);

        // Check if a photo is uploaded
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $path = $request->file('photo')->store('food_item_photos', 'public');
            $data['photo'] = $path; // Save the photo path
        }

        // Create the food item with photo path (if uploaded)
        $foodItem = FoodItem::create($data);

        return response()->json($foodItem, 201);
    }


    // Update an existing food item
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'category' => 'nullable|string',
            'stock' => 'sometimes|required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for photo
        ]);

        // Find the food item by ID
        $foodItem = FoodItem::find($id);
        if (!$foodItem) {
            return response()->json(['message' => 'Food item not found'], 404);
        }

        // Prepare data for update
        $data = $request->only(['name', 'description', 'price', 'category', 'stock']);

        // Check if a new photo is uploaded
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo if it exists
            if ($foodItem->photo) {
                Storage::disk('public')->delete($foodItem->photo);
            }

            // Store the new photo
            $path = $request->file('photo')->store('food_item_photos', 'public');
            $data['photo'] = $path; // Update photo path
        }

        // Update the food item with new data
        $foodItem->update($data);

        return response()->json($foodItem, 200);
    }



    // Delete a food item
    public function destroy($id)
    {
        $foodItem = FoodItem::find($id);
        if (!$foodItem) {
            return response()->json(['message' => 'Food item not found'], 404);
        }

        $foodItem->delete();
        return response()->json(['message' => 'Food item deleted successfully'], 200);
    }
}
