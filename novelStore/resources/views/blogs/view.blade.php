<?php
/** @var \App\Models\Blog $blog */
?>
<x-layout>
    <x-slot:title>Post: {{ $blog->title }}</x-slot:title>

    <h1 class="mb-3">{{ $blog->title }}</h1>

    @if($blog->pic !== null && \Storage::exists($blog->pic))
        <div style="text-align: center;">
            <img src="{{ \Storage::url($blog->pic) }}" alt="{{ $blog->pic_description }}" style="width: 520px; height: 320px;">
        </div>
    @endif

    <dl class="mb-3">
        <dt>Temática</dt>
        <dd>{{$blog->theme->name}}</dd>
        <dt>Contenido</dt>
        <dd>{{ $blog->content }}</dd>
        <dt>Fecha de Creación</dt>
        <dd>{{ $blog->created_at }}</dd>
    </dl>

        <!-- Botón para volver a publicaciones -->
        <div class="mb-3">
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Volver a Publicaciones</a>
    </div>
    
</x-layout>
