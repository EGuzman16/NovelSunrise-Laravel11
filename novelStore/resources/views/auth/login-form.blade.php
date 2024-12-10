<x-layout>
    <x-slot:title>Iniciar Sesión</x-slot:title>

    <h1 class="mb-3">Ingresar a mi Cuenta</h1>

    <form action="{{ route('auth.login.process') }}" method="post">
        @csrf 
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
</x-layout>
