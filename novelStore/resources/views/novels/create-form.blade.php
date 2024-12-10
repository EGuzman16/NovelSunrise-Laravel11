<x-layout>
    <x-slot:title>Publicar una Nueva Novela</x-slot:title>

    <h1 class="mb-3">Publicar una Novela</h1>

    @if($errors->any())
    <div class="alert alert-danger">Hay errores en los datos del formulario. Por favor, revisalos y volvé a intentar.</div>
    @endif

    <form action="{{ route('novels.create.process') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}">
            @error('price')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="release_date" class="form-label">Fecha de Edición</label>
            <input type="date" id="release_date" name="release_date" class="form-control" value="{{ old('release_date') }}">
            @error('release_date')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_fk" class="form-label">Categoría</label>
            <select id="category_fk" name="category_fk" class="form-control">
                <option value="">Selecciona la categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->category_id }}" @selected($category->category_id == old('category_fk'))
                    >
                    {{ $category->name }} ({{ $category->abbreviation }})
                </option>
                @endforeach
            </select>
            @error('category_fk')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="synopsis" class="form-label">Sinopsis</label>
            <textarea id="synopsis" name="synopsis" class="form-control">{{ old('synopsis') }}</textarea>
            @error('synopsis')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <fieldset class="mb-3">
            <legend>Etiquetas</legend>
            @foreach($tags as $tag)
            <label class="me-4">
                <input type="checkbox" name="tag_fk[]" value="{{ $tag->tag_id }}" @checked( in_array($tag->tag_id, old('tag_fk', [])) )
                >
                {{ $tag->name }}
            </label>
            @endforeach
        </fieldset>

        <div class="mb-3">
            <label for="cover" class="form-label">Portada</label>
            <input
                type="file"
                id="cover"
                name="cover"
                class="form-control"
            >
            @error('cover')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cover_description" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="cover_description"
                name="cover_description"
                class="form-control"
                value="{{ old('cover_description') }}"
            >
            @error('cover_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
</x-layout>
