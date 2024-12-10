<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var App\Models\Novel $novel */
?>
<x-layout>
    <x-slot:title>Editar la Novela "{{ $novel->title }}"</x-slot:title>

    @if($errors->any())
    <div class="alert alert-danger mb-4">Hay errores en los datos del formulario. Por favor, revisalos y vuelve a intentar.</div>
    @endif

    <h1 class="mb-3">Editar la Novela "{{ $novel->title }}"</h1>

    <form action="{{ route('novels.edit.process', ['id' => $novel->novel_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title', $novel->title) }}"
            >
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input
                type="text"
                id="price"
                name="price"
                class="form-control"
                value="{{ old('price', $novel->price) }}"
            >
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="release_date" class="form-label">Fecha de Edición</label>
            <input
                type="date"
                id="release_date"
                name="release_date"
                class="form-control"
                value="{{ old('release_date', $novel->release_date->format('Y-m-d')) }}"
            >
            @error('release_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_fk" class="form-label">Categoría</label>
            <select
                id="category_fk"
                name="category_fk"
                class="form-control"
            >
                <option value="">Selecciona la categoría</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->category_id }}"
                        @selected($category->category_id == old('category_fk', $novel->category_fk))
                    >
                        {{ $category->name }} ({{ $category->abbreviation }})
                    </option>
                @endforeach
            </select>
            @error('category_fk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="synopsis" class="form-label">Sinopsis</label>
            <textarea
                id="synopsis"
                name="synopsis"
                class="form-control"
            >{{ old('synopsis', $novel->synopsis) }}</textarea>
            @error('synopsis')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        
        <fieldset class="mb-3">
            <legend>Etiquetas</legend>
            @foreach($tags as $tag)
            <label class="me-4">
                <input type="checkbox" name="tag_fk[]" value="{{ $tag->tag_id }}" @checked( in_array( $tag->tag_id, old('tag_fks', $novel->tags->pluck('tag_id')->toArray()) ) )
                >
                {{ $tag->name }}
            </label>
            @endforeach
        </fieldset>

        <div class="mb-3">
            <p class="mb-2">Portada actual</p>
            @if($novel->cover !== null && \Storage::exists($novel->cover))
                <img src="{{ \Storage::url($novel->cover) }}" alt="">
            @else
                <p>Sin portada</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Portada</label>
            <input
                type="file"
                id="cover"
                name="cover"
                class="form-control"
            >
            @error('cover')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cover_description" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="cover_description"
                name="cover_description"
                class="form-control"
                value="{{ old('cover_description', $novel->cover_description) }}"
            >
            @error('cover_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
</x-layout>
