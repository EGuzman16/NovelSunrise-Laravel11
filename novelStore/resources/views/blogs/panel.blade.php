<x-layout>
    <x-slot:title>Blogs</x-slot:title>

    <h1>Listado de Publicaciones</h1>

    <div class="mb-3">
        <a href="{{ route('blogs.create.form') }}" class="btn btn-success">Publicar un nuevo post</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Temática</th>
                <th>Fecha de Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td>
                    @if($blog->pic !== null && \Storage::exists($blog->pic))
                        <img src="{{ \Storage::url($blog->pic) }}" alt="{{ $blog->pic_description }}" style="width: 50px; height: 50px;">
                    @endif
                </td>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->theme->name }}</td>
                <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('blogs.view', ['id' => $blog->blog_id]) }}" class="btn btn-primary btn-sm">Ver</a>
                    <a href="{{ route('blogs.edit.form', ['id' => $blog->blog_id]) }}" class="btn btn-secondary btn-sm">Editar</a>
                    <form action="{{ route('blogs.delete.process', ['id' => $blog->blog_id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $blogs->links() }}
</x-layout>