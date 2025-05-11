<?php

namespace App\Http\Controllers;

use App\Models\verficacion;
use Inertia\Inertia;
use Illuminate\Http\Request;

class VerficacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Verificacion.Index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(verficacion $verficacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(verficacion $verficacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, verficacion $verficacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(verficacion $verficacion)
    {
        //
    }
}
