<?php

namespace App\Http\Controllers\FormaFarmaceutica;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionFormaFarmaceutica;
use App\Models\FormaFarmaceutica\Preparacion;
use Illuminate\Http\Request;

class FormaFarmaceuticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filtro = $request->get('buscarpor');
        $formas = Preparacion::where('Pre_descripcion', 'like', '%'.$filtro.'%')            
                             ->paginate(15);
        return view('formaFarmaceutica.index', compact('formas', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('formaFarmaceutica.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionFormaFarmaceutica $request)
    {
        $forma = new Preparacion;
        $forma->Pre_descripcion = $request->Pre_descripcion;
        $forma->Pre_unidadMedida = $request->Pre_unidadMedida;
        $forma->save();
        $notificacion = array(
            'mensaje' => 'Forma farmacéutica creada con exito',
            'tipo' => 'success',
            'titulo' => 'Forma farmacéutica'
        );
        return redirect('formaFarmaceutica')->with($notificacion);
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
    public function editar($Pre_codigo)
    {
        $forma = Preparacion::where('Pre_codigo', '=', $Pre_codigo)
                        ->first();
        return view('formaFarmaceutica.editar', compact('forma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionFormaFarmaceutica $request, $Pre_codigo)
    {
        $forma = Preparacion::where('Pre_codigo', '=', $Pre_codigo)
                               ->first();
        $forma->Pre_descripcion = $request->Pre_descripcion;
        $forma->Pre_unidadMedida = $request->Pre_unidadMedida;
        $forma->update();

        $notificacion = array(
            'mensaje' => 'Forma Farmacéutica actualizada con éxito',
            'tipo' => 'success',
            'titulo' => 'Forma Farmacéutica'
        );
        return redirect('formaFarmaceutica')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Pre_codigo)
    {
        $forma = Preparacion::where('Pre_codigo', '=', $Pre_codigo)
                            ->first();
        if ($request->ajax()) {
            if ($forma->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
