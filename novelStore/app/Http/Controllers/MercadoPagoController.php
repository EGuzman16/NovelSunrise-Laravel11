<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Payments\MercadoPagoPayment;
use Illuminate\Http\Request;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function show()
    {
        $novels = Novel::whereIn('novel_id', [1, 3])->get();

        $items = [];
        foreach($novels as $novel) {
            $items[] = [
                'title' => $novel->title,
                'unit_price' => $novel->price,
                'quantity' => 1,
            ];
        }

        MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));
        $preferenceFactory = new PreferenceClient();
        $preference = $preferenceFactory->create([
            'items' => $items,

            'back_urls' => [
                'success' => route('test.mercadopago.successProcess'),
                'pending' => route('test.mercadopago.pendingProcess'),
                'failure' => route('test.mercadopago.failureProcess'),
            ],
            'auto_return' => 'approved',
        ]);

        return view('mercadopago.form', [
            'novels' => $novels,
            'preference' => $preference,
            'mpPublicKey' => config('mercadopago.public_key'),
        ]);
    }

    public function showV2()
    {
        $novels = Novel::whereIn('novel_id', [1, 3])->get();

        $items = [];

        foreach($novels as $novel) {
            $items[] = [
                'title' => $novel->title,
                'unit_price' => $novel->price,
                'quantity' => 1,
            ];
        }

        $payment = new MercadoPagoPayment();
        $payment->setItems($items);
        $payment->setBackURLs(
            success: route('test.mercadopago.successProcess'),
            pending: route('test.mercadopago.pendingProcess'),
            failure: route('test.mercadopago.failureProcess')
        );
        $payment->withAutoReturn();
        $preference = $payment->getPreference();

        return view('mercadopago.form', [
            'novels' => $novels,
            'preference' => $preference,

            'mpPublicKey' => $payment->getPublicKey(),
        ]);
    }

    public function successProcess(Request $request)
    {
        dd($request->query());
    }

    public function pendingProcess(Request $request)
    {
        dd($request->query());
    }

    public function failureProcess(Request $request)
    {
        dd($request->query());
    }
}