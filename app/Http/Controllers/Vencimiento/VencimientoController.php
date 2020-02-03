<?php

namespace App\Http\Controllers\Vencimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionVencimiento;
use App\Models\Vencimiento\Vencimiento;
use Illuminate\Http\Request;

class VencimientoController extends Controller
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
        $vencimientos = Vencimiento::where('Ven_cantidad', 'like', "%$filtro%")            
                             ->paginate(15);
        return view('vencimiento.index', compact('vencimientos', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('vencimiento.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionVencimiento $request)
    {
        $vencimiento = new Vencimiento;
        $vencimiento->Ven_cantidad = $request->Ven_cantidad;
        $vencimiento->Ven_tipo = $request->Ven_tipo;
        $vencimiento->save();
        $notificacion = array(
            'mensaje' => 'Vencimiento creado con exito',
            'tipo' => 'success',
            'titulo' => 'Vencimiento'
        );
        return redirect('vencimiento')->with($notificacion);
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
    public function editar($Ven_codigo)
    {
        $vencimiento = Vencimiento::where('Ven_codigo', '=', $Ven_codigo)
                        ->first();
        return view('vencimiento.editar', compact('vencimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionVencimiento $request, $Ven_codigo)
    {
        $vencimiento = vencimiento::where('Ven_codigo', '=', $Ven_codigo)
                               ->first();
        $vencimiento->Ven_cantidad = $request->Ven_cantidad;
        $vencimiento->Ven_tipo = $request->Ven_tipo;
        $vencimiento->update();

        $notificacion = array(
            'mensaje' => 'Vencimiento actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Vencimiento'
        );
        return redirect('vencimiento')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Ven_codigo)
    {
        $vencimiento = vencimiento::where('Ven_codigo', '=', $Ven_codigo)
                            ->first();
        if ($request->ajax()) {
            if ($vencimiento->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
