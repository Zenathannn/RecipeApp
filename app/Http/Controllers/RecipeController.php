<?php
// app/Http/Controllers/RecipeController.php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::latest('created_at')->paginate(9);
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
        ]);

        // Handle upload file
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('recipes', $imageName, 'public');
            $validated['image_path'] = $imagePath;
        }

        Recipe::create($validated);

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe berhasil ditambahkan!');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle upload file baru
        if ($request->hasFile('image_file')) {
            // Hapus gambar lama jika ada
            if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
                Storage::disk('public')->delete($recipe->image_path);
            }

            $image = $request->file('image_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('recipes', $imageName, 'public');
            $validated['image_path'] = $imagePath;

            // Clear image_url jika upload file baru
            $validated['image_url'] = null;
        }

        $recipe->update($validated);

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe berhasil diupdate!');
    }

    public function destroy(Recipe $recipe)
    {
        // Hapus gambar jika ada
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe berhasil dihapus!');
    }
}
