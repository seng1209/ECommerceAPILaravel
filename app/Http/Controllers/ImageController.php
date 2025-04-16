<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{

    public function index()
    {
        // Get all images from the storage
        $images = Storage::disk('public')->files('images');

        // Prepare the response array with name, extension, and access link
        $imageDetails = array_map(function ($image) {
            $filename = basename($image); // Get the filename
            $extension = pathinfo($filename, PATHINFO_EXTENSION); // Get the file extension
            $accessLink = asset('storage/' . $image); // Create the access link

            return [
                'name' => $filename,
                'extension' => $extension,
                'link' => $accessLink,
            ];
        }, $images);

        // Return as JSON response
        return response()->json($imageDetails);
    }

    public function upload(Request $request)
    {
        // Validate the image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Generate a unique filename using UUID
        $uuid = (string) Str::uuid();
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = "$uuid.$extension";

        // Store the image
        $path = $request->file('image')->storeAs('images', $filename, 'public');

        // Create a public access link
        $accessLink = asset('storage/' . $path);

        // Return response
        return response()->json([
            'filename' => $filename,
            'extension' => $extension,
            'link' => $accessLink,
        ]);
    }

    public function show($filename)
    {
        // Construct the path to the image
        $path = 'images/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            // Get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // Create the access link
            $accessLink = asset('storage/' . $path);

            // Return the image details
            return response()->json([
                'name' => $filename,
                'extension' => $extension,
                'link' => $accessLink,
            ]);
        } else {
            return response()->json(['error' => 'Image not found!'], 404);
        }
    }

    public function delete($filename)
    {
        // Construct the path to the image
        $path = 'images/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            // Delete the image
            Storage::disk('public')->delete($path);

            return response()->json(['success' => 'Image deleted successfully!']);
        } else {
            return response()->json(['error' => 'Image not found!'], 404);
        }
    }

    public function deleteAll()
    {
        // Get all images from the storage
        $images = Storage::disk('public')->files('images');

        // Delete each image
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        return response()->json(['success' => 'All images deleted successfully!']);
    }
}
