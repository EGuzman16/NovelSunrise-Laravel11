<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Obtener los datos de la novela y el precio desde el formulario
        $novelTitle = $request->input('novel_title');
        $price = $request->input('price');
        $cover = $request->input('cover'); // Obtener la URL de la imagen de la novela

        // Crear el historial de compra
        PurchaseHistory::create([
            'user_id' => Auth::id(),
            'novel_title' => $novelTitle,
            'price' => $price,
            'cover' => $cover,
            'status' => 'pending',
        ]);

        return redirect()->route('profile.edit')->with('success', 'Compra realizada con éxito. Estado: Pendiente.');
    }
}