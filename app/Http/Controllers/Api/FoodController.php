<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('email');

if ($email) {

    $foods = Food::where('is_public', true)
        ->orWhere('user_email', $email)
        ->latest()
        ->get();

} else {

    $foods = Food::where('is_public', true)
        ->latest()
        ->get();
}

        return response()->json($foods);
    }

public function store(Request $request)
{
    $imagePath = null;

    if ($request->hasFile('image')) {

        $imagePath = $request->file('image')
            ->store('foods', 'public');
    }

$food = Food::create([
    'user_email' => $request->user_email,
    'food_name' => $request->food_name,
    'description' => $request->description,
    'image_url' => $imagePath,
    'is_public' => false
]);

return response()->json([
    'id' => $food->id,
    'user_email' => $food->user_email,
    'food_name' => $food->food_name,
    'description' => $food->description,
    'image_url' => $food->image_url,
    'is_public' => (int) $food->is_public
]);
}

public function update(Request $request, $id)
{
    $food = Food::findOrFail($id);

    if ($food->is_public) {

        return response()->json([
            'message' => 'Data bawaan tidak dapat diedit'
        ], 403);
    }

    $food->food_name = $request->food_name;
    $food->description = $request->description;

    if ($request->hasFile('image')) {

        if (
            $food->image_url &&
            Storage::disk('public')->exists($food->image_url)
        ) {
            Storage::disk('public')->delete($food->image_url);
        }

        $food->image_url = $request->file('image')
            ->store('foods', 'public');
    }

    $food->save();

    return response()->json($food);
}

public function destroy($id)
{
    $food = Food::findOrFail($id);

    if ($food->is_public) {

        return response()->json([
            'message' => 'Data bawaan tidak dapat dihapus'
        ], 403);
    }

    if (
        $food->image_url &&
        Storage::disk('public')->exists($food->image_url)
    ) {
        Storage::disk('public')->delete($food->image_url);
    }

    $food->delete();

    return response()->json([
        'message' => 'Data berhasil dihapus'
    ]);
}
}
