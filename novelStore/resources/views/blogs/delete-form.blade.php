<?php
/** @var \App\Models\Blog $blog */
?>
<x-layout>
    <x-slot:title>Confirmación Necesaria para Eliminar la publicación "{{ $blog->title }}"</x-slot:title>

    <h1 class="mb-3">Se Requiere Confirmación</h1>

    <p class="mb-3">Estás por eliminar el siguiente post, y se requiere de una confirmación para proseguir.</p>

    <hr>

    <h2 class="mb-3">{{ $blog->title }}</h2>

    <dl class="mb-3">
        <dt>Contenido</dt>
        <dd>{{ $blog->content }}</dd>
    </dl>

    <hr>

    <form
        action="{{ route('blogs.delete.process', ['id' => $blog->blog_id]) }}"
        method="post"
        class="ms-2"
    >
        @csrf
        <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
    </form>
</x-layout>

