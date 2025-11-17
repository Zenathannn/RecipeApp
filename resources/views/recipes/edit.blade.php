{{-- resources/views/recipes/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Recipe</h1>

        <form action="{{ route('recipes.update', $recipe->id_recipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $recipe->username) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('username') border-red-500 @enderror">
                @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select name="category"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('category') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    <option value="Makanan Utama" {{ old('category', $recipe->category) == 'Makanan Utama' ? 'selected' : '' }}>Makanan Utama</option>
                    <option value="Dessert" {{ old('category', $recipe->category) == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                    <option value="Minuman" {{ old('category', $recipe->category) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack" {{ old('category', $recipe->category) == 'Snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Judul Recipe</label>
                <input type="text" name="title" value="{{ old('title', $recipe->title) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="5"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $recipe->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($recipe->image_path || $recipe->image_url)
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Gambar Saat Ini</label>
                <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}"
                    class="w-full h-48 object-cover rounded-lg border">
                <p class="text-gray-500 text-sm mt-1">
                    @if($recipe->image_path)
                    Gambar dari upload file
                    @else
                    Gambar dari URL
                    @endif
                </p>
            </div>
            @endif

            <!-- Upload New File -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar Baru</label>
                <input type="file" name="image_file" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('image_file') border-red-500 @enderror"
                    onchange="previewImage(event)">
                @error('image_file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Upload file baru jika ingin mengganti gambar. Format: JPG, PNG, GIF. Maksimal 2MB</p>

                <!-- Preview Image -->
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="preview" class="w-full h-48 object-cover rounded-lg border" alt="Preview">
                </div>
            </div>

            <div class="mb-4">
                <div class="flex items-center justify-center my-4">
                    <div class="border-t border-gray-300 flex-grow"></div>
                    <span class="px-4 text-gray-500 font-medium">ATAU</span>
                    <div class="border-t border-gray-300 flex-grow"></div>
                </div>
            </div>

            <!-- URL Image -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">URL Gambar</label>
                <input type="url" name="image_url" value="{{ old('image_url', $recipe->image_url) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('image_url') border-red-500 @enderror">
                @error('image_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Update Recipe
                </button>
                <a href="{{ route('recipes.show', $recipe->id_recipe) }}"
                    class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    }
</script>
@endsection