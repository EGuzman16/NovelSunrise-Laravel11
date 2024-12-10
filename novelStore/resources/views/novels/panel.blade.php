<x-layout>
    <x-slot:title>Catálogo de Novelas</x-slot:title>

    <h1>Listado de Novelas</h1>

    <div class="mb-3">
        <a href="{{ route('novels.create.form') }}" class="btn btn-success">Publicar una nueva Novela</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Precio</th>
                <th>Fecha de Lanzamiento</th>
                <th>Categoría</th>
                <th>Etiquetas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($novels as $novel)
            <tr>
                <td>
                    @if($novel->cover !== null && \Storage::exists($novel->cover))
                        <img src="{{ \Storage::url($novel->cover) }}" alt="{{ $novel->cover_description }}" style="width: 50px; height: 50px;">
                    @endif
                </td>
                <td>{{ $novel->title }}</td>
                <td>${{ $novel->price }}</td>
                <td>{{ $novel->release_date->format('d/m/Y') }}</td>
                <td>{{ $novel->category->abbreviation }}</td>
                <td>
                    @forelse($novel->tags as $tag)
                    <span class="badge bg-info">{{ $tag->name }}</span>
                    @empty
                    <i>Sin etiquetas</i>
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('novels.view', ['id' => $novel->novel_id]) }}" class="btn btn-primary btn-sm">Ver</a>
                    <a href="{{ route('novels.edit.form', ['id' => $novel->novel_id]) }}" class="btn btn-secondary btn-sm">Editar</a>
                    <form action="{{ route('novels.delete.process', ['id' => $novel->novel_id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $novels->links() }}
</x-layout>