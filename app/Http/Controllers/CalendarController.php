<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Evento;
use App\Models\Foro;
use App\Models\Horario;
use App\Models\Organizador;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;


class CalendarController extends Controller
{
    public function index()
    {


        $eve = Evento::with([
            'horario' => function ($query) {
                $query->withoutTrashed();
            },
            'foro',
            'organizador',
            'user',
        ])->withoutTrashed()->get();

        $eventosLista = []; // Inicializar el array de eventos

        foreach ($eve as $evento) {
            // Accedemos a los horarios del evento
            foreach ($evento->horario as $horario) {
                // Modificar la fecha de inicio y fin
                $horario->start = $horario->start_date . ' ' . $horario->start_hour;
                $horario->end = $horario->end_date . ' ' . $horario->end_hour;

                // Agregar el evento a la lista de eventos
                $eventosLista[] = [
                    'id'          => $evento->id,
                    'title'       => $evento->title,
                    'start'       => $horario->start, // Usar las fechas y horas modificadas
                    'end'         => $horario->end,

                    'tipo_evento' => $evento->tipo_evento,
                    'notas_generales' => $evento->notas_generales ?? "sin notas",
                    'notas_cta' => $evento->notas_cta ?? "Sin notas",

                    'organizador_id' => $evento->organizador->id,
                    'organizador_nombre' => $evento->organizador->nombre,
                    'organizador_telefono' => $evento->organizador->telefono,

                    'foro_id'   => $evento->foro->id,
                    'foro_nombre'   => $evento->foro->nombre,
                    'foro_sede'   => $evento->foro->sede,
                    'user_name' => $evento->user->name,
                    //'color'       => '#3788d8', // Color opcional
                ];
            }
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
            'eve' => $eve,
        ]);
        //return view('welcome', ['eventosLista' => $eventosLista]);
    }

    public function store(Request $request)
    {
        // Validación de datos de entrada
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tipo_evento' => 'required|string|max:35',
            'foros_id' => 'required|exists:foros,id',
            'organizadors_id' => 'required|exists:organizadors,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_hour' => 'required|date_format:H:i',
            'end_hour' => 'required|date_format:H:i|after:start_hour',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // Verificar disponibilidad del foro
            $conflicto = Horario::where('eventos_id', '!=', null)
                ->whereHas('evento', function ($query) use ($request) {
                    $query->where('foros_id', $request->foros_id);
                })
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                })
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_hour', [$request->start_hour, $request->end_hour])
                        ->orWhereBetween('end_hour', [$request->start_hour, $request->end_hour]);
                })
                ->exists();

            if ($conflicto) {
                return redirect()->back()->with('error', 'El foro ya está ocupado en el horario seleccionado.');
            }

            // Crear el evento
            $evento = Evento::create([
                'users_id' => auth()->id() ?? null, // Si hay usuario autenticado
                'title' => $request->title,
                'tipo_evento' => $request->tipo_evento,
                'foros_id' => $request->foros_id,
                'organizadors_id' => $request->organizadors_id,
                'notas_generales' => $request->notas_generales,
                'notas_cta' => $request->notas_cta,
            ]);

            // Generar horarios individuales por cada día del rango
            $fechaInicio = Carbon::parse($request->start_date);
            $fechaFin = Carbon::parse($request->end_date);

            while ($fechaInicio->lte($fechaFin)) {
                Horario::create([
                    'eventos_id' => $evento->id,
                    'start_date' => $fechaInicio->toDateString(),
                    'end_date' => $fechaInicio->toDateString(),
                    'start_hour' => $request->start_hour,
                    'end_hour' => $request->end_hour,
                ]);

                // Avanza al siguiente día
                $fechaInicio->addDay();
            }

            DB::commit();
            return response()->json(['message' => 'Evento creado con éxito', 'evento' => $evento], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el evento', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
{
    // Validación de datos
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'tipo_evento' => 'required|string|max:35',
        'foros_id' => 'required|exists:foros,id',
        'organizadors_id' => 'required|exists:organizadors,id',
        'start_date' => 'required|date',
        'start_hour' => 'required',
        'end_date' => 'required|date|after_or_equal:start_date',
        'end_hour' => 'required|after:start_hour',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();
    try {
        // Buscar el evento
        $evento = Evento::findOrFail($id);

        // Obtener todos los horarios del evento
        $horarios = Horario::where('eventos_id', $evento->id)->get();

        if ($horarios->isEmpty()) {
            return response()->json(['error' => 'No se encontraron horarios asociados al evento.'], 400);
        }

        // Verificar si hay conflicto de horarios con otros eventos
        foreach ($horarios as $horario) {
            $conflicto = Horario::where('eventos_id', '!=', $evento->id)
                ->whereHas('evento', function ($query) use ($request) {
                    $query->where('foros_id', $request->foros_id);
                })
                ->where(function ($query) use ($request, $horario) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                          ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                })
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_hour', [$request->start_hour, $request->end_hour])
                          ->orWhereBetween('end_hour', [$request->start_hour, $request->end_hour]);
                })
                ->exists();

            if ($conflicto) {
                return response()->json(['error' => 'El foro ya está ocupado en el horario seleccionado.'], 400);
            }
        }

        // Actualizar datos del evento
        $evento->update([
            'title' => $request->title,
            'tipo_evento' => $request->tipo_evento,
            'foros_id' => $request->foros_id,
            'organizadors_id' => $request->organizadors_id,
            'notas_generales' => $request->notas_generales,
            'notas_cta' => $request->notas_cta,
        ]);
        // Eliminar los horarios existentes del evento
            Horario::where('eventos_id', $evento->id)->delete();

            // Recrear los horarios manteniendo la continuidad de los días
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
        // Actualizar todos los horarios asociados al evento
        while ($startDate->lte($endDate)) {
            Horario::create([
                'eventos_id' => $evento->id, // Solo necesita la referencia al evento
                'start_date' => $startDate->toDateString(),
                'end_date' => $startDate->toDateString(),
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
            ]);
            $startDate->addDay(); // Pasar al siguiente día
        }

        DB::commit();
        return response()->json(['message' => 'Evento y horarios actualizados con éxito', 'evento' => $evento], 200);
        } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Error al actualizar el evento', 'details' => $e->getMessage()], 500);
    }
}

/*

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',

            'users_id' => 'required|exists:users,id',
            'foros_id' => 'required|exists:foros,id',
            'organizadors_id' => 'required|exists:organizadors,id',

            'notas_cta' => 'nullable|string',
            'notas_generales' => 'nullable|string',
            'tipo_evento' => 'required|string|max:255'
        ]);

        $evento = Evento::findOrFail($id);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $horaInicio = $start_date->format('H:i:s');
        $horaFin = $end_date->format('H:i:s');
        $fechaActual = $start_date->format('Y-m-d');

        // Verificar si el nuevo horario entra en conflicto con otro evento
        try {
            // Verificar si ya existe un evento en el mismo foro y fecha (y opcionalmente, en el mismo horario)
            $eventoExistente = Evento::where('foros_id', $request->foro)
                ->where('id', '!=', $id)
                ->whereDate('start_date', $fechaActual)
                ->where(function ($query) use ($horaInicio, $horaFin) {
                    // Verificamos si el evento actual se solapa con algún otro evento en el mismo foro
                    $query->whereBetween(DB::raw("TIME(start_date)"), [$horaInicio, $horaFin])
                        ->orWhereBetween(DB::raw("TIME(end_date)"), [$horaInicio, $horaFin])
                        ->orWhereRaw('? BETWEEN TIME(start_date) AND TIME(end_date)', [$horaInicio])
                        ->orWhereRaw('? BETWEEN TIME(start_date) AND TIME(end_date)', [$horaFin]);
                })
                ->exists();

            if ($eventoExistente) {
                return response()->json([
                    'error' => 'Ya existe un evento en el lugar y día.',
                ], 422);
            }
            $evento->update([
                'users_id' => Auth::user()->id,
                'organizadors_id' => $request->organizador,
                'foros_id' => $request->foro,

                'title' => $request->title,
                'start_date' => "$fechaActual $horaInicio",
                'end_date' => "$fechaActual $horaFin",

                'tipo_evento' => $request->tipoEvento,
                'notas_generales' => $request->notasGen,
                'notas_cta' => $request->notasCta,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e
            ]);
        }
        return response()->json(['message' => 'Evento actualizado correctamente']);
    }
*/
    public function destroy($id)
    {

        try {
            $evento = Evento::findOrFail($id);
            $evento->delete();

            return redirect()->route('dashboard')->with('success', 'Evento eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error al eliminar el Evento');
        }
    }

    public function obtenerEvento($id)
    {
        try {
            $evento = Evento::with(['', 'foro', 'organizador', 'user'])->find($id);

            if (!$evento) {
                return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
            }

            return response()->json([
                'success' => true,
                'evento' => [
                    'id' => $evento->id,
                    'title' => $evento->title,
                    'tipo_evento' => $evento->tipo_evento,
                    'notas_generales' => $evento->notas_generales,
                    'notas_cta' => $evento->notas_cta,
                    'foro_id' => $evento->foro->id ?? '',
                    'organizador_id' => $evento->organizador->id ?? '',
                    'foro_nombre' => $evento->foro->nombre ?? '',
                    'foro_sede' => $evento->foro->sede ?? '',
                    'user_name' => $evento->user->name ?? '',
                    //'registrador' => $evento->user->name ?? '',
                    //'start_date' => optional($evento->horario->first())->start_date . ' ' . optional($evento->horario->first())->start_hour,
                    //'end_date' => optional($evento->horario->first())->end_date . ' ' . optional($evento->horario->first())->end_hour,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
