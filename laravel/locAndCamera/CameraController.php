<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index()
    {
        return view('camera');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        dd($request->all());

        return redirect()->route('camera.index')->with('success', 'Image uploaded successfully.');
    }
}
