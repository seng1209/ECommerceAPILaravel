<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        return response()->json(Slider::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = 'storage/' . $request->file('image')->store('sliders', 'public');
        }

        $slider = Slider::create($validated);

        return response()->json($slider, 201);
    }

    public function update(Request $request, Slider $slider)
    {
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $slider->image));
            $validated['image'] = 'storage/' . $request->file('image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return response()->json($slider);
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image && Storage::disk('public')->exists(str_replace('storage/', '', $slider->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $slider->image));
        }

        $slider->delete();

        return response()->json(['message' => 'Slider deleted successfully'], 200);
    }
}
