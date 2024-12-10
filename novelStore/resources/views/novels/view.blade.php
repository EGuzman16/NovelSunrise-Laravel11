
<x-layout>
    <x-slot:title>Detalles de {{ $novel->title }}</x-slot:title>

    <h1 class="mb-3">{{ $novel->title }}</h1>

    @if($novel->cover !== null && \Storage::exists($novel->cover))
        <img src="{{ \Storage::url($novel->cover) }}" alt="{{ $novel->cover_description }}">
    @endif

    <dl class="mb-3">
        <dt>Precio</dt>
        <dd>${{ $novel->price }}</dd>
        <dt>Fecha de Edición</dt>
        <dd>{{ $novel->release_date }}</dd>
        <dt>Categoría</dt>
        <dd>{{ $novel->category->name }} ({{ $novel->category->abbreviation }})</dd>
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
    <div>{{ $novel->synopsis }}</div>

            <!-- Botón para volver a publicaciones -->
            <div class="mb-3">
        <a href="{{ route('novels.index') }}" class="btn btn-secondary">Volver al catálogo</a>
    </div>

</x-layout>
