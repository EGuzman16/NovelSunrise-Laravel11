<x-layout>
    <x-slot:title>Administrador</x-slot:title>

    <h1>Bienvenidos al Administrador</h1>
    <p>Desde acá podrás administrar tus pantallas.</p>

    <div class="d-flex justify-content-around mt-4">
        <a href="{{ route('novels.panel') }}" class="btn btn-primary">Catálogo de Novelas</a>
        <a href="{{ route('blogs.panel') }}" class="btn btn-primary">Blogs</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Usuarios</a>
    </div>
</x-layout>