<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Asistencia;
use Inertia\Inertia;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        return Inertia::render('Asistencia/Scan');
    }

    public function registrar(Request $request)
    {
        $estudiante = Estudiante::where('codigo', $request->codigo)->first();

        if (!$estudiante) {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no encontrado'], 404);
        }

        $hoy = Carbon::today();

        $ultimaAsistencia = Asistencia::where('estudiante_id', $estudiante->id)
            ->whereDate('fecha', $hoy)
            ->orderByDesc('hora')
            ->first();

        if (!$ultimaAsistencia) {
            // No hay asistencia hoy → Registrar ENTRADA
            Asistencia::create([
                'estudiante_id' => $estudiante->id,
                'fecha' => $hoy,
                'hora' => Carbon::now()->toTimeString(),
                'estado' => 1, // entrada
            ]);

            return response()->json(['status' => 'success', 'message' => 'Asistencia registrada (Entrada)']);
        }

        if ($ultimaAsistencia->estado == 1) {
            // Ya registró entrada → Registrar SALIDA
            Asistencia::create([
                'estudiante_id' => $estudiante->id,
                'fecha' => $hoy,
                'hora' => Carbon::now()->toTimeString(),
                'estado' => 0, // salida
            ]);

            return response()->json(['status' => 'success', 'message' => 'Salida registrada']);
        }

        // Ya tiene una salida hoy
        return response()->json(['status' => 'info', 'message' => 'Ya registró entrada y salida hoy']);
    }
}
