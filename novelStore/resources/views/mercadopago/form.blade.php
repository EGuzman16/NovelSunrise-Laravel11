<?php

/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Novel[] $novels */
/** @var \MercadoPago\Resources\Preference $preference */
/** @var string $mpPublicKey */
?>
<x-layout>
    <x-slot:title>Mercado Pago</x-slot:title>

    <h1 class="mb-3"> Mercado Pago</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($novels as $novel)
            <tr>
                <td>{{ $novel->title }}</td>
                <td>${{ $novel->price }}</td>
                <td>1</td>
                <td>${{ $novel->price }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><b>TOTAL:</b></td>
                <td><b>${{ $novels->sum('price') }}</b></td>
            </tr>
        </tbody>
    </table>


    <div id="mercadopago-button"></div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago('<?= $mpPublicKey; ?>');
        mp.bricks().create("wallet", "mercadopago-button", {
            initialization: {
                preferenceId: '<?= $preference->id; ?>',
            },
            customization: {
                texts: {
                    valueProp: 'smart_option',
                },
            }
        });
    </script>
</x-layout>