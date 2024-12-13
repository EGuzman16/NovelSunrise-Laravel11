<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Models\User;
use App\Models\Novel;
use App\Models\Blog;

class AdminPurchaseController extends Controller
{
    public function index()
    {
        
        $userCount = User::count();
        $novelCount = Novel::count();
        $blogCount = Blog::count();
        $pendingPurchasesCount = PurchaseHistory::where('status', 'PENDIENTE')->count();
        $paidPurchasesCount = PurchaseHistory::where('status', 'PAGO')->count();

    
        $purchaseHistories = PurchaseHistory::with('user')->paginate(6);

        return view('admin.index', [
            'userCount' => $userCount,
            'novelCount' => $novelCount,
            'blogCount' => $blogCount,
            'pendingPurchasesCount' => $pendingPurchasesCount,
            'paidPurchasesCount' => $paidPurchasesCount,
            'purchaseHistories' => $purchaseHistories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $purchaseHistory = PurchaseHistory::findOrFail($id);
        $purchaseHistory->status = $request->input('status');
        $purchaseHistory->save();

        return redirect()->route('admin.index')->with('success', 'Estado de la compra actualizado correctamente.');
    }
}