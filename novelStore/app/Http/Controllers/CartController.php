<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Novel;

class CartController extends Controller
{
    public function show()
    {
        $cart = Session::get('cart', []);
        $novels = Novel::whereIn('novel_id', array_keys($cart))->get();

        return view('cart', [
            'novels' => $novels,
            'cart' => $cart,
        ]);
    }

    public function add(Request $request)
    {
        $novelId = $request->input('novel_id');
        $cart = Session::get('cart', []);
        if (isset($cart[$novelId])) {
            $cart[$novelId]++;
        } else {
            $cart[$novelId] = 1;
        }
        Session::put('cart', $cart);

        return redirect()->route('cart.show');
    }

    public function remove(Request $request)
    {
        $novelId = $request->input('novel_id');
        $cart = Session::get('cart', []);
        if (isset($cart[$novelId])) {
            unset($cart[$novelId]);
        }
        Session::put('cart', $cart);

        return redirect()->route('cart.show');
    }

    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.show');
    }
}