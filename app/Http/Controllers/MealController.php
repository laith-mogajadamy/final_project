<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealController extends Controller
{
    // List all meals with their associated food items
    public function index()
    {
        $meals = Meal::with('foodItems')->get();
        return response()->json($meals, 200);
    }

    // Show a single meal with its food items
    public function show($id)
    {
        $meal = Meal::with('foodItems')->find($id);
        if ($meal) {
            return response()->json($meal, 200);
        }
        return response()->json(['message' => 'Meal not found'], 404);
    }

    // Create a new meal and associate food items
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'sometimes|required|integer',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validate photo
        ]);

        $data = $request->only(['name', 'description', 'price','stock']);

        // Handle file upload
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        $meal = Meal::create($data);

        // Attach food items to the meal
        $meal->foodItems()->attach($request->food_item_ids);

        // Reload meal with attached food items
        $meal->load('foodItems');

        return response()->json($meal, 201);
    }

    // Update an existing meal and its food items
    public function update(Request $request, $id)
    {
        // Retrieve the meal record
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['message' => 'Meal not found'], 404);
        }

        // Validate the request
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'food_item_ids' => 'array',
            'food_item_ids.*' => 'exists:food_items,id'
        ]);

        // Prepare the data for update (excluding the photo field for now)
        $data = $request->only(['name', 'description', 'price','stock']);

        // Check if there's a new photo in the request
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo if it exists
            if ($meal->photo) {
                Storage::disk('public')->delete($meal->photo);
            }

            // Store the new photo
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;  // Save the new photo path
        }

        // Update the meal with the new data
        $meal->update($data);

        // Sync food items if provided
        if ($request->has('food_item_ids')) {
            $meal->foodItems()->sync($request->food_item_ids);
        }

        // Reload meal with updated food items
        $meal->load('foodItems');

        return response()->json($meal, 200);
    }



    // Delete a meal and detach its associated food items
    public function destroy($id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['message' => 'Meal not found'], 404);
        }

        // Detach all food items associated with this meal
        $meal->foodItems()->detach();

        // Delete the meal itself
        $meal->delete();

        return response()->json(['message' => 'Meal deleted successfully'], 200);
    }
}
