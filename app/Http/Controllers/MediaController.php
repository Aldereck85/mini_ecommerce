<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;


use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::all();
        return $media;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'type_id' => 'required|exists:types_media,id',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'price_day' => 'required|numeric|min:0',
        ]);

        $imagePath = $request->file('imagen')->store('media', 'public');

        Media::create([
            'name' => $request->name,
            'location_id' => $request->location_id,
            'type_id' => $request->type_id,
            'image' => $imagePath,
            'price_day' => $request->price_day,
        ]);

        return redirect()->route('index')->with('success', 'Medio creado exitosamente');
    }
}
