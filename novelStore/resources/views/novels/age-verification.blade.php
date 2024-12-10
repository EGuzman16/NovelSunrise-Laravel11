<?php
/** @var \App\Novels\Novel $novel */
?>
<x-layout>
    <x-slot:title>Confirmación de Mayoría de Edad</x-slot:title>

    <h1 class="mb-3">Verificación Necesaria</h1>

    <p class="mb-3">La novela <b>{{ $novel->title }}</b> es Apta Mayores de 18 Años".</p>
    <p class="mb-3">Para poder continuar, es necesario verificar el requisito.</p>

    <form action="{{ route('novels.age-verification.process', ['id' => $novel->novel_id]) }}" method="post">
        @csrf
        <a href="{{ route('novels.index') }}" class="btn btn-danger">No soy mayor de edad.</a>
        <button type="submit" class="ms-2 btn btn-success">Sí soy mayor de edad</button>
    </form>
</x-layout>
