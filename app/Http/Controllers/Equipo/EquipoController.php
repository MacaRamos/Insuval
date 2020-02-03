<?php

namespace App\Http\Controllers\Equipo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionEquipo;
use App\Models\Equipo\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->buscarpor);
        $filtro = $request->get('buscarpor');
        $equipos = Equipo::where('Equ_nombre', 'like', "%$filtro%")            
                             ->paginate(15);
        return view('equipo.index', compact('equipos', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('equipo.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionEquipo $request)
    {
        $equipo = new equipo;
        $equipo->Equ_nombre = $request->Equ_nombre;
        $equipo->save();
        $notificacion = array(
            'mensaje' => 'Equipo creado con exito',
            'tipo' => 'success',
            'titulo' => 'Equipo'
        );
        return redirect('equipo')->with($notificacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($Equ_codigo)
    {
        $equipo = Equipo::where('Equ_codigo', '=', $Equ_codigo)
                        ->first();
        return view('equipo.editar', compact('equipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionEquipo $request, $Equ_codigo)
    {
        $equipo = Equipo::where('Equ_codigo', '=', $Equ_codigo)
                               ->first();
        $equipo->Equ_nombre = $request->Equ_nombre;
        $equipo->update();

        $notificacion = array(
            'mensaje' => 'Equipo actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Equipo'
        );
        return redirect('equipo')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Equ_codigo)
    {
        $equipo = Equipo::where('Equ_codigo', '=', $Equ_codigo)
                            ->first();
        if ($request->ajax()) {
            if ($equipo->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
