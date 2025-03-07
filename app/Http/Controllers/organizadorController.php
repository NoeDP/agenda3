<?php

namespace App\Http\Controllers;

use App\Models\Organizador;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class organizadorController extends Controller
{
    public function fetchOrganizadores(Request $request)
    {
    // Paginación de organizadores
    $organizadores = Organizador::paginate(10); // 10 organizadores por página

    if ($request->ajax()) {
        return response()->json([
            'html' => view('organizadores.partials.cards', compact('organizadores'))->render(),
            'pagination' => (string) $organizadores->links()
        ]);
    }

    return view('organizadores.index', compact('organizadores'));
}
    public function update(Request $request)
    
    {
        $mensajes = [
            'editOrganizadorNombre.required' => 'El Nombre del organizador es obligatorio.',
            'editOrganizadorTelefono.required' => 'El telefono del organizador es obligatorio.',
            'editOrganizadorID.required' => 'La id es obligatoria.',
        ];

            $validator = Validator::make($request->all(), [
                'editOrganizadorNombre' => 'required|string',
                'editOrganizadorTelefono' => 'required|string',
                'editOrganizadorID' => 'required',
            ],$mensajes);

            if ($validator->fails()) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); */ // Código 422 para errores de validación
                return redirect()->route('dashboard')->with('error', $validator->errors());
            }

            try {
                $organizador = Organizador::find($request->editOrganizadorID);
    
                if (!$organizador) {
                    return response()->json(['message' => 'organizador no encontrado'], 404);
                }
    
                $organizador->nombre = $request->editOrganizadorNombre;
                $organizador->telefono = $request->editOrganizadorTelefono;
    
                $organizador->save();

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
                return redirect()->route('dashboard')->with('error', 'Error al actualizar el organizador');
            }   
    }
    public function store(Request $request)
    {
        $mensajes = [
            'OrganizadorNombre.required' => 'El Nombre del organizador es obligatorio.',
            'OrganizadorTelefono.required' => 'El telefono del organizador es obligatorio.',
        ];

            $validator = Validator::make($request->all(), [
                'OrganizadorNombre' => 'required|string',
                'OrganizadorTelefono' => 'required|string',
                
            ],$mensajes);

            if ($validator->fails()) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); */ // Código 422 para errores de validación
                return redirect()->route('dashboard')->with('error', $validator->errors());
            }

            try {
                $organizador = Organizador::create([
                    'nombre'=> $request->OrganizadorNombre,
                    'telefono'=> $request->OrganizadorTelefono,
                ]);
                /* return response()->json([
                    'success' => true,
                    'mensaje' => "Se ha guardado correctamente"
                ], 200);  */
                return redirect()->route('dashboard')->with('success', 'Se ha creado correctamente');

            } catch (\Exception $e) {
                /* return response()->json([
                    'success' => false,
                    'errors' => $e
                ], 422);  */
                return redirect()->route('dashboard')->with('error', 'Error al crear el organizador');
            }   
    }

    public function destroy($id)
    {
        try {
            $organizador = Organizador::find($id);

            if (!$organizador) {
                return response()->json(['message' => 'Foro no encontrado'], 404);
            }

            $organizador->delete();

            /* return response()->json([
                'success' => true,
                'mensaje' => "Se ha eliminado correctamente"
            ], 200);  */
            return redirect()->route('dashboard')->with('success', 'Se ha eliminado correctamente');
           
        } catch (\Exception $e) {
            /* return response()->json([
                'success' => false,
                'errors' => $e
            ], 422); */ 
            return redirect()->route('dashboard')->with('error', 'Error al eliminar el organizador');
        }
        
    }
}
