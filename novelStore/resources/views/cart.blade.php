<x-layout>
    <x-slot:title>Carrito de Compras</x-slot:title>

    <h1>Carrito de Compras</h1>

    @if($novels->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($novels as $novel)
                    @php $subtotal = $novel->price * $cart[$novel->novel_id]; @endphp
                    @php $total += $subtotal; @endphp
                    <tr>
                        <td>
                            @if($novel->cover !== null && \Storage::exists($novel->cover))
                                <img src="{{ \Storage::url($novel->cover) }}" alt="{{ $novel->cover_description }}" style="width: 50px; height: 50px;">
                            @endif
                        </td>
                        <td>{{ $novel->title }}</td>
                        <td>${{ $novel->price }}</td>
                        <td>{{ $cart[$novel->novel_id] }}</td>
                        <td>${{ $subtotal }}</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="novel_id" value="{{ $novel->novel_id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>Total: ${{ $total }}</h4>
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Vaciar Carrito</button>
            </form>
        </div>

        <form action="{{ route('payment.process') }}" method="POST" class="mt-3">
            @csrf
            @foreach($novels as $novel)
                <input type="hidden" name="novels[{{ $loop->index }}][title]" value="{{ $novel->title }}">
                <input type="hidden" name="novels[{{ $loop->index }}][price]" value="{{ $novel->price }}">
                <input type="hidden" name="novels[{{ $loop->index }}][cover]" value="{{ $novel->cover }}">
            @endforeach
            <input type="hidden" name="total" value="{{ $total }}">
            <button type="submit" class="btn btn-primary">Proceder al Pago</button>
        </form>
    @else
        <p>No hay artículos en el carrito.</p>
    @endif
</x-layout>