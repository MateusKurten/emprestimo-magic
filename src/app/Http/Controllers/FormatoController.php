<?php

namespace App\Http\Controllers;

use App\Models\Formato;
use Illuminate\Http\Request;

class FormatoController extends Controller
{
    public function index()
    {
        $formatos = Formato::all();
        return view('formatos.index', [
            'formatos' => $formatos,
        ]);
    }
}
