<x-layout>
    <x-slot:title>Publicar un Post</x-slot:title>

    @if($errors->any())
    <div class="alert alert-danger mb-4">Hay errores en los datos del formulario, vuelve a intentarlo.</div>
    @endif

    <h1 class="mb-3">Publicar un nuevo Post</h1>

    <form action="{{ route('blogs.create.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
    <label for="theme_fk" class="form-label">Temática</label>
    <select id="theme_fk" name="theme_fk" class="form-control">
        <option value="">Selecciona el temática</option>
        @foreach($themes as $theme)
        <option value="{{ $theme->theme_id }}">{{ $theme->name }}</option>
    @endforeach
    </select>
    @error('theme_fk')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea id="content" name="content" class="form-control">{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pic" class="form-label">Imagen destacada</label>
            <input
                type="file"
                id="pic"
                name="pic"
                class="form-control"
            >
            @error('pic')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="pic_description" class="form-label">Título de la imagen</label>
            <input
                type="text"
                id="pic_description"
                name="pic_description"
                class="form-control"
                value="{{ old('pic_description') }}"
            >
            @error('pic_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
    </x-layout>
