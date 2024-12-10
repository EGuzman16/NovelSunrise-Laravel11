<?php
/** @var \App\Models\Novel $novel */
?>
<x-layout>
    <x-slot:title>Confirmación Necesaria para Eliminar la Novela "{{ $novel->title }}"</x-slot:title>

    <h1 class="mb-3">Se Requiere Confirmación</h1>

    <p class="mb-3">Estás por eliminar la siguiente novela, y se requiere de una confirmación para proseguir.</p>

    <hr>

    <h2 class="mb-3">{{ $novel->title }}</h2>

    <dl class="mb-3">
        <dt>Precio</dt>
        <dd>${{ $novel->price }}</dd>
        <dt>Fecha de Estreno</dt>
        <dd>{{ $novel->release_date }}</dd>
        <dt>Etiquetas</dt>
        <dd>
            @forelse($novel->tags as $tag)
                <span class="badge bg-info">{{ $tag->name }}</span>
            @empty
                <i>Sin etiqueta</i>
            @endforelse
        </dd>
    </dl>

    <h2 class="mb-2">Sinopsis</h2>
    <div class="mb-3">{{ $novel->synopsis }}</div>

    <hr>

    <form
        action="{{ route('novels.delete.process', ['id' => $novel->novel_id]) }}"
        method="post"
        class="ms-2"
    >
        @csrf
        <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
    </form>
</x-layout>
