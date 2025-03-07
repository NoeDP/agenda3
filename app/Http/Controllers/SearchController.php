<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use App\Models\Foro;
use App\Models\Organizador;
use App\Models\User;

class SearchController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('q');
        $tipo = $request->input('tipo');

        if ($tipo === 'foros') {
            $resultados = Foro::search($query)->get();
        } elseif ($tipo === 'users') {
            $resultados = User::search($query)->get();
        } elseif ($tipo === 'organizadores') {
            $resultados = Organizador::search($query)->get();
        } elseif ($tipo === 'eventos') {
            $resultados = Evento::search($query)->get();
        } else {
            $resultados = collect();
        }

        return response()->json($resultados);
    }
}
