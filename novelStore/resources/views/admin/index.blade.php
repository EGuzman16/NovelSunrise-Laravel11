<x-layout>
    <x-slot:title>Administrador</x-slot:title>

    <h1>Bienvenidos al Administrador</h1>
    <p>Desde acá podrás administrar tus pantallas.</p>

    <div class="d-flex justify-content-around mt-4">
        <a href="{{ route('novels.panel') }}" class="btn btn-primary">Catálogo de Novelas</a>
        <a href="{{ route('blogs.panel') }}" class="btn btn-primary">Blogs</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Usuarios</a>
    </div>

    <h2 class="mt-4">Estadísticas</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Usuarios Registrados</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Novelas Cargadas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $novelCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Blogs Publicados</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $blogCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Compras PENDIENTE</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $pendingPurchasesCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Compras PAGO</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $paidPurchasesCount }}</h5>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-4">Historial de Compras</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Imagen</th>
                <th>Título de la Novela</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseHistories as $history)
                <tr>
                    <td>{{ $history->user->name }}</td>
                    <td>
                        @if($history->cover && \Storage::exists($history->cover))
                            <img src="{{ \Storage::url($history->cover) }}" alt="{{ $history->novel_title }}" style="width: 50px; height: 50px;">
                        @else
                            <img src="{{ asset('img/default-cover.png') }}" alt="Imagen no disponible" style="width: 50px; height: 50px;">
                        @endif
                    </td>
                    <td>{{ $history->novel_title }}</td>
                    <td>${{ $history->price }}</td>
                    <td>
                        <span class="badge {{ $history->status == 'PAGO' ? 'bg-success' : 'bg-danger' }}">
                            {{ $history->status }}
                        </span>
                    </td>
                    <td>{{ $history->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('admin.purchase.update', $history->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control">
                                @foreach(\App\Models\PurchaseHistory::getStatusOptions() as $status)
                                    <option value="{{ $status }}" {{ $history->status == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm mt-1">Actualizar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $purchaseHistories->links() }}
    </div>
</x-layout>