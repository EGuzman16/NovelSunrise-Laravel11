<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var App\Models\Blog $blog */
?>
<x-layout>
    <x-slot:title>Editar el Blog "{{ $blog->title }}"</x-slot:title>

    @if($errors->any())
    <div class="alert alert-danger mb-4">Hay errores en los datos del formulario. Por favor, revísalos y vuelve a intentar.</div>
    @endif

    <h1 class="mb-3">Editar el Blog "{{ $blog->title }}"</h1>

    <form action="{{ route('blogs.edit.process', ['id' => $blog->blog_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title', $blog->title) }}"
            >
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="theme_fk" class="form-label">Temática</label>
            <select
                id="theme_fk"
                name="theme_fk"
                class="form-control"
            >
                <option value="">Selecciona la temática</option>
                @foreach($themes as $theme)
                    <option
                        value="{{ $theme->theme_id }}"
                        @selected($theme->theme_id == old('theme_fk', $blog->theme_fk))
                    >
                        {{ $theme->name }} 
                    </option>
                @endforeach
            </select>
            @error('theme_fk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea
                id="content"
                name="content"
                class="form-control"
            >{{ old('content', $blog->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <p class="mb-2">Portada actual</p>
            @if($blog->pic !== null && \Storage::exists($blog->pic))
                <img src="{{ \Storage::url($blog->pic) }}" alt="{{ $blog->pic_description }}">
            @else
                <p>Sin portada</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="pic" class="form-label">Imagen destacada</label>
            <input
                type="file"
                id="pic"
                name="pic"
                class="form-control"
            >
            @error('pic')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="pic_description" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="pic_description"
                name="pic_description"
                class="form-control"
                value="{{ old('pic_description', $blog->pic_description) }}"
            >
            @error('pic_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
</x-layout>

