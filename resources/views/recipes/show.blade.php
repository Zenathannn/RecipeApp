@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($recipe->image)
        <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}"
            class="w-full h-96 object-cover">
        @else
        <div class="w-full h-96 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
            <span class="text-9xl">🍽️</span>
        </div>
        @endif

        <div class="p-8">
            <div class="mb-4">
                <span class="inline-block bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full">
                    {{ $recipe->category }}
                </span>
            </div>

            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $recipe->title }}</h1>

            <div class="flex items-center gap-6 text-gray-600 mb-6 pb-6 border-b">
                <div class="flex items-center gap-2">
                    <span class="text-xl">👤</span>
                    <span>{{ $recipe->username }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">📅</span>
                    <span>{{ $recipe->created_at->format('d F Y') }}</span>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-3">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $recipe->description }}</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('recipes.edit', $recipe->id_recipe) }}"
                    class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition font-semibold">
                    Edit Recipe
                </a>
                <form action="{{ route('recipes.destroy', $recipe->id_recipe) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus recipe ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition font-semibold">
                        Hapus Recipe
                    </button>
                </form>
                <a href="{{ route('recipes.index') }}"
                    class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection