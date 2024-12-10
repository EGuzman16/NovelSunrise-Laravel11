<x-layout>
    <x-slot:title>Perfil de Usuario</x-slot:title>

    <h1>Perfil de Usuario</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </form>

    <h2 class="mt-4">Historial de Compras</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título de la Novela</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseHistories as $history)
                <tr>
                    <td>
                        @if($history->cover)
                            <img src="{{ $history->cover }}" alt="{{ $history->novel_title }}" style="width: 50px; height: 50px;">
                        @endif
                    </td>
                    <td>{{ $history->novel_title }}</td>
                    <td>${{ $history->price }}</td>
                    <td>{{ $history->status }}</td>
                    <td>{{ $history->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>