<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Payments\MercadoPagoPayment;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Obtener el carrito de compras de la sesión
        $cart = Session::get('cart', []);

        // Obtener las novelas en el carrito
        $novels = Novel::whereIn('novel_id', array_keys($cart))->get();

        // Crear los ítems de la preferencia
        $items = [];
        foreach ($novels as $novel) {
            $items[] = [
                'title' => $novel->title,
                'unit_price' => $novel->price,
                'quantity' => $cart[$novel->novel_id],
            ];

            // Crear el historial de compra
            PurchaseHistory::create([
                'user_id' => Auth::id(),
                'novel_title' => $novel->title,
                'price' => $novel->price,
                'cover' => $novel->cover,
                'status' => 'pending',
            ]);
        }

        // Crear la preferencia de pago
        $payment = new MercadoPagoPayment();
        $payment->setItems($items);
        $payment->setBackURLs(
            success: route('payment.success'),
            pending: route('payment.pending'),
            failure: route('payment.failure')
        );
        $payment->withAutoReturn();
        $preference = $payment->getPreference();

        // Limpiar el carrito de compras
        Session::forget('cart');

        // Redirigir al formulario de pago de MercadoPago
        return view('mercadopago.form', [
            'novels' => $novels,
            'preference' => $preference,
            'mpPublicKey' => $payment->getPublicKey(),
        ]);
    }

    public function success()
    {
        return redirect()->route('profile.edit')->with('success', 'Compra realizada con éxito. Estado: Aprobado.');
    }

    public function failure()
    {
        return redirect()->route('profile.edit')->with('error', 'Hubo un problema con el pago. Por favor, inténtelo de nuevo.');
    }

    public function pending()
    {
        return redirect()->route('profile.edit')->with('warning', 'El pago está pendiente. Por favor, verifica más tarde.');
    }
}