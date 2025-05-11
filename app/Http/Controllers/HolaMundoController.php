<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HolaMundoController extends Controller
{
    public function index()
    {
        return Inertia::render('Hola/HolaMundo', [
            'nombre' => 'Cristian',
            'mensaje' => 'Bienvenido al mundo de Inertia + Vue + Laravel!'
        ]);
    }
}
