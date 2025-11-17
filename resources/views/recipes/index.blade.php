@extends('layouts.app')

@section('title', 'Daftar Recipe')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Recipe</h1>
    <p class="text-gray-600 mt-2">Temukan berbagai resep masakan favorit Anda</p>
</div>

@if($recipes->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($recipes as $recipe)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
        @if($recipe->image)
        <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}"
            class="w-full h-48 object-cover">
        @else
        <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
            <span class="text-6xl">🍽️</span>
        </div>
        @endif

        <div class="p-5">
            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full mb-2">
                {{ $recipe->category }}
            </span>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $recipe->title }}</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $recipe->description }}</p>

            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <span>👤 {{ $recipe->username }}</span>
                <span>📅 {{ $recipe->created_at->format('d M Y') }}</span>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('recipes.show', $recipe->id_recipe) }}"
                    class="flex-1 bg-indigo-600 text-white text-center px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Lihat Detail
                </a>
                <a href="{{ route('recipes.edit', $recipe->id_recipe) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                    Edit
                </a>
                <form action="{{ route('recipes.destroy', $recipe->id_recipe) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus recipe ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $recipes->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <p class="text-gray-500 text-lg mb-4">Belum ada recipe. Yuk tambahkan recipe pertama Anda!</p>
    <a href="{{ route('recipes.create') }}"
        class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
        + Tambah Recipe
    </a>
</div>
@endif
@endsection