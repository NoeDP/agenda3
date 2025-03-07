<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Foro;

use App\Models\horarios;
use App\Models\Organizador;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class dashboard extends Controller
{
    public function dashboard()
    {

        $organizadores = Organizador::withoutTrashed()->get(); // Solo los que no están eliminados
        $foros = Foro::withoutTrashed()->get(); // Solo los que no están eliminados
        $users = User::withoutTrashed()->get(); // Si los usuarios tienen SoftDeletes
        //$horarios = horarios::withoutTrashed()->get(); // Si los horarios tienen SoftDeletes
        //$eventos = Evento::withoutTrashed()->get(); // Solo los eventos activos
        $eventos = Evento::withoutTrashed()
            ->with([
                'horario' => function ($query) {
                    $query->withoutTrashed();
                },
                'foro',
                'organizador'
            ])
            ->get();
        $dependencias = Foro::select('sede', DB::raw('MIN(id) as id'))
            ->groupBy('sede')
            ->get();

        return view('dashboard', [
            'organizadores' => $organizadores,
            'foros' => $foros,
            'users' => $users,
            'eventos' => $eventos,
            'dependencias' => $dependencias,
        ]);
    }
    public function welcome()
    {
        $sedes = Foro::select('sede', DB::raw('MIN(id) as id'))
            ->groupBy('sede')
            ->get();

        $eventosLista = array();
        $eventos = Evento::with(['user', 'foro', 'organizador'])->get();
        foreach ($eventos as $evento) {
            $eventosLista[] = [
                'id' => $evento->id,
                'title' => $evento->title,
                'start' => $evento->start_date,
                'end' => $evento->end_date,

                'tipoEvento' => $evento->tipo_evento,
                'notasGen' => $evento->notas_generales,
                'notasCta' => $evento->notas_cta,
                'organizador_id' => $evento->organizador->id,
                'organizador_nombre' => $evento->organizador->nombre,
                'organizador_telefono' => $evento->organizador->telefono,

                'foro_id' => $evento->foro->id,
                'foro_nombre' => $evento->foro->nombre,
                'foro_sede' => $evento->foro->sede,

                'registrador' => $evento->registrador,
                'user_name' => $evento->user->name,
                'user_id' => $evento->user->id

            ];
        }

        $organizadores = Organizador::withoutTrashed()->get(); // Solo los que no están eliminados
        $foros = Foro::withoutTrashed()->get(); // Solo los que no están eliminados
        //$dependencias = Foro::all();
        $dependencias = Foro::select('sede', DB::raw('MIN(id) as id'))
            ->groupBy('sede')
            ->get();


        return view('welcome', [
            'eventosLista' => $eventosLista,
            'organizadores' => $organizadores,
            'foros' => $foros,
            'dependencias' => $dependencias,
            'sedes' => $sedes,
        ]);
    }

    public function welcome2($sedeId)
    {
        $sedes = Foro::select('sede', DB::raw('MIN(id) as id'))
            ->groupBy('sede')
            ->get();

        $eventosLista = array();
        $eventos = Evento::with(['user', 'foro', 'organizador'])->get();
        foreach ($eventos as $evento) {
            $eventosLista[] = [
                'id' => $evento->id,
                'title' => $evento->title,
                'start' => $evento->start_date,
                'end' => $evento->end_date,

                'tipoEvento' => $evento->tipo_evento,
                'notasGen' => $evento->notas_generales,
                'notasCta' => $evento->notas_cta,
                'organizador_id' => $evento->organizador->id,
                'organizador_nombre' => $evento->organizador->nombre,
                'organizador_telefono' => $evento->organizador->telefono,

                'foro_id' => $evento->foro->id,
                'foro_nombre' => $evento->foro->nombre,
                'foro_sede' => $evento->foro->sede,

                'registrador' => $evento->registrador,
                'user_name' => $evento->user->name,
                'user_id' => $evento->user->id

            ];
        }

        $organizadores = Organizador::withoutTrashed()->get(); // Solo los que no están eliminados
        $foros = Foro::withoutTrashed()->get(); // Solo los que no están eliminados
        //$dependencias = Foro::all();
        $dependencias = Foro::select('sede', DB::raw('MIN(id) as id'))
            ->groupBy('sede')
            ->get();


        return view('welcome', [
            'eventosLista' => $eventosLista,
            'organizadores' => $organizadores,
            'foros' => $foros,
            'dependencias' => $dependencias,
            'sedes' => $sedes,
        ]);
    }
}
