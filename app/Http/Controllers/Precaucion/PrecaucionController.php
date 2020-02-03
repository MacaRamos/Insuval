<?php

namespace App\Http\Controllers\Precaucion;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionPrecaucion;
use App\Models\Precauciones\Precaucion;
use Illuminate\Http\Request;

class PrecaucionController extends Controller
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
        $precauciones = Precaucion::where('Cau_descripcion', 'like', "%$filtro%")            
                             ->paginate(15);
        return view('precaucion.index', compact('precauciones', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('precaucion.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionPrecaucion $request)
    {
        $precaucion = new Precaucion;
        $precaucion->Cau_descripcion = $request->Cau_descripcion;
        $precaucion->save();
        $notificacion = array(
            'mensaje' => 'Precaución creada con exito',
            'tipo' => 'success',
            'titulo' => 'Precaución'
        );
        return redirect('precaucion')->with($notificacion);
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
    public function editar($Cau_codigo)
    {
        $precaucion = Precaucion::where('Cau_codigo', '=', $Cau_codigo)
                        ->first();
        return view('precaucion.editar', compact('precaucion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionPrecaucion $request, $Cau_codigo)
    {
        $precaucion = Precaucion::where('Cau_codigo', '=', $Cau_codigo)
                               ->first();
        $precaucion->Cau_descripcion = $request->Cau_descripcion;
        $precaucion->update();

        $notificacion = array(
            'mensaje' => 'Precaución actualizada con éxito',
            'tipo' => 'success',
            'titulo' => 'Precaución'
        );
        return redirect('precaucion')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Cau_codigo)
    {
        $precaucion = Precaucion::where('Cau_codigo', '=', $Cau_codigo)
                            ->first();
        if ($request->ajax()) {
            if ($precaucion->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
