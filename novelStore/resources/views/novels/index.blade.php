<?php

/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Novel[] $novels */
?>
<x-layout>
    <x-slot:title>Catálogo de Novelas</x-slot:title>

    <h1>Listado de Novelas</h1>

    <section class="mb-3">
        <h2 class="mb-2">Buscador</h2>
        <form action="{{ route('novels.index') }}" method="get" class="d-flex align-items-end gap-3 mb-3">
            <div>
                <label for="sTitle" class="form-label">Título</label>
                <input type="text" id="sTitle" name="sTitle" class="form-control" value="{{ $searchParams['sTitle'] ?? null }}">
            </div>
            <div>
                <label for="sCategory" class="form-label">Categoría</label>
                <select name="sCategory" id="sCategory" class="form-control">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                    <option
                        value="{{ $category->category_id }}"
                        @selected($category->category_id == ($searchParams['sCategory'] ?? null))
                    >
                        {{ $category->name }} ({{ $category->abbreviation }})
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </section>

    @if($novels->isNotEmpty())
    @auth
        @if(auth()->user()->role === 'Admin')
        <div class="mb-3">
            <a href="{{ route('novels.create.form') }}">Publicar una nueva Novela</a>
        </div>
        @endif
    @endauth

    @if($novels->isNotEmpty())
    <div class="row">
        @foreach($novels as $novel)
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card">
            @if($novel->cover !== null && \Storage::exists($novel->cover))
                <img src="{{ \Storage::url($novel->cover) }}" alt="{{ $novel->cover_description }}">
            @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $novel->title }}</h5>
                    <p class="card-text">${{ $novel->price }}</p>
                    <p class="card-text">{{ $novel->release_date->format('d/m/Y') }}</p>
                    <p class="card-text">{{ $novel->category->abbreviation }}</p>
                    <div>
                        @forelse($novel->tags as $tag)
                        <span class="badge bg-info">{{ $tag->name }}</span>
                        @empty
                        <i>Sin etiquetas</i>
                        @endforelse
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <a href="{{ route('novels.view', ['id' => $novel->novel_id]) }}" class="btn btn-primary btn-sm">Ver</a>
                        <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="novel_id" value="{{ $novel->novel_id }}">
                            <button type="submit" class="btn btn-success btn-sm">Comprar</button>
                        </form>
                        @auth
                            @if(auth()->user()->role === 'Admin')
                            <a href="{{ route('novels.edit.form', ['id' => $novel->novel_id]) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <a href="{{ route('novels.delete.form', ['id' => $novel->novel_id]) }}" class="btn btn-danger btn-sm">Eliminar</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
    {{ $novels->links() }}
    @elseif($searchParams->contains(fn ($value) => $value != null))        
        <p>No hay ninguna novela que coincidan con el criterio de búsqueda especificado.</p>
    @else
    <p>No hay Novelas que mostrar actualmente. @auth Puedes empezar por <a href="{{ route('novels.create.form') }}">subir una novela</a>. @endauth</p>
    @endif
</x-layout>