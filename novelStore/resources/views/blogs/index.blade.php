<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Blog[] $blogs */
?>
<x-layout>
    <x-slot:title>Lista de Blogs</x-slot:title>

    <h1>Listado de Publicaciones</h1>

    <section class="mb-3">
        <h2 class="mb-2">Buscador</h2>
        <form action="{{ route('blogs.index') }}" method="get" class="d-flex align-items-end gap-3 mb-3">
            <div>
                <label for="sTitle" class="form-label">Título</label>
                <input type="text" id="sTitle" name="sTitle" class="form-control" value="{{ $searchParams['sTitle'] ?? null }}">
            </div>
            <div>
                <label for="sTheme" class="form-label">Temática</label>
                <select name="sTheme" id="sTheme" class="form-control">
                    <option value="">Todas</option>
                    @foreach($themes as $theme)
                    <option
                        value="{{ $theme->theme_id }}"
                        @selected($theme->theme_id == ($searchParams['sTheme'] ?? null))
                    >
                        {{ $theme->name }} 
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </section>

    @if($blogs->isNotEmpty())
    
    @auth
        @if(auth()->user()->role === 'Admin')
        <div class="mb-3">
            <a href="{{ route('blogs.create.form') }}" class="btn btn-primary">Publicar un nuevo post</a>
        </div>
        @endif
    @endauth

    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card transition-transform duration-300 hover:scale-105">
                @if($blog->pic !== null && \Storage::exists($blog->pic))
                <img src="{{ \Storage::url($blog->pic) }}" alt="{{ $blog->pic_description }}" class="card-img-top" style="height: 320px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text p-2 bg-gray-100 rounded">{{ $blog->theme->name }}</p>
                    <p class="card-text">{{ $blog->created_at }}</p>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <a href="{{ route('blogs.view', ['id' => $blog->blog_id]) }}" class="btn btn-primary btn-sm">Ver</a>
                        @auth
                            @if(auth()->user()->role === 'Admin')
                            <a href="{{ route('blogs.edit.form', ['id' => $blog->blog_id]) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <a href="{{ route('blogs.delete.form', ['id' => $blog->blog_id]) }}" class="btn btn-danger btn-sm">Eliminar</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $blogs->links() }}
    @elseif($searchParams->contains(fn ($value) => $value != null))        
        <p>No hay ningun post que coincidan con el criterio de búsqueda especificado.</p>
    @else
        <p>No hay ningún post actualmente publicado. @auth Puede empezar por <a href="{{ route('blogs.create.form') }}">publicar el primero</a>. @endauth </p>
    @endif

</x-layout>