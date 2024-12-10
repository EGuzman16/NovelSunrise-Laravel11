<?php

namespace App\Http\Controllers;

use App\Models\Novel;
//use Illuminate\Http\Request;

class AgeVerificationController extends Controller
{
    public function ageVerificationForm(int $id)
    {
        return view('novels.age-verification', [
            'novel' => Novel::findOrFail($id),
        ]);
    }

    public function ageVerificationProcess(int $id)
    {
        session()->put('age-verified', true);

        return to_route('novels.view', ['id' => $id]); 
    }
}
