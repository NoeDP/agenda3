<?php

namespace App\Http\Controllers;

use App\Models\Foro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ForoController extends Controller
{
    public function update(Request $request)
    {
        $mensajes = [
            'editForoNombre.required' => 'El Nombre del foro es obligatorio.',
            'editForoSede.required' => 'La sede a la que pertenece el foro es obligatoria.',
            'editForoId.required' => 'La id es obligatoria.',
        ];

            $validator = Validator::make($request->all(), [
                'editForoNombre' => 'required|string',
                'editForoSede' => 'required|string',
                'editForoId' => 'required',
            ],$mensajes);

            if ($validator->fails()) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); */ // Código 422 para errores de validación
                return redirect()->route('dashboard')->with('error', $validator->errors());
            }

            try {
                $foro = Foro::find($request->editForoId);
    
                if (!$foro) {
                    return response()->json(['message' => 'Foro no encontrado'], 404);
                }
    
                $foro->nombre = $request->editForoNombre;
                $foro->sede = $request->editForoSede;
    
                $foro->save();

                /* return response()->json([
                    'success' => true,
                    'mensaje' => "Se ha guardado correctamente"
                ], 200);  */
                return redirect()->route('dashboard')->with('success', 'Se ha actualizado correctamente');

            } catch (\Exception $e) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $e
                ], 422);  */
                return redirect()->route('dashboard')->with('error', 'Error al actualizar el foro');
            }   
    }
    public function store(Request $request)
    {
        $mensajes = [
            'foroNombre.required' => 'El Nombre del foro es obligatorio.',
            'foroSede.required' => 'La sede a la que pertenece el foro es obligatoria.',
        ];

            $validator = Validator::make($request->all(), [
                'foroNombre' => 'required|string',
                'foroSede' => 'required|string',
                
            ],$mensajes);

            if ($validator->fails()) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); */ // Código 422 para errores de validación
                return redirect()->route('dashboard')->with('error', $validator->errors());
            }

            try {
                $foro = Foro::create([
                    'nombre'=> $request->foroNombre,
                    'sede'=> $request->foroSede,
                ]);
                /* return response()->json([
                    'success' => true,
                    'mensaje' => "Se ha guardado correctamente"
                ], 200);  */
                return redirect()->route('dashboard')->with('success', 'Se ha guardado correctamente');

            } catch (\Exception $e) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $e
                ], 422);  */
                return redirect()->route('dashboard')->with('error', 'Error al crear el foro');
            }   
    }


    public function destroy($id)
    {
        try {
            $foro = Foro::find($id);

            if (!$foro) {
                return response()->json(['message' => 'Foro no encontrado'], 404);
            }

            $foro->delete();

            /* return response()->json([
                'success' => true,
                'mensaje' => "Se ha eliminado correctamente"
            ], 200);  */
            return redirect()->route('dashboard')->with('success', 'Se ha eliminado correctamente');
           
        } catch (\Exception $e) {
           /*  return response()->json([
                'success' => false,
                'errors' => $e
            ], 422);  */
            return redirect()->route('dashboard')->with('error', 'Error al eliminar el foro');
        }
        
    }
    public function obtenerForosPorDependencia($sede)
    {
        // Filtrar los foros según la sede (dependencia)
        $foros = Foro::where('sede', $sede)->get();
        
        return response()->json($foros);
    }
}
