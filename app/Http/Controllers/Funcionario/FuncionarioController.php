<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionFuncionario;
use App\Models\Funcionario\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
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
        $funcionarios = Funcionario::where('Fun_nombre', 'like', "%$filtro%") 
                                   ->where('Fun_apellido', 'like', "%$filtro%")
                                   ->where('Fun_tipo', '=', "QM")
                                   ->orWhere('Fun_tipo', '=', "AM")
                                   ->orWhere('Fun_tipo', '=', "DT")
                                   ->paginate(15);
        return view('funcionario.index', compact('funcionarios', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('funcionario.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionFuncionario $request)
    {
        $funcionario = new funcionario;
        $funcionario->Fun_rut = $request->Fun_rut;
        $funcionario->Fun_dv = $request->Fun_dv;
        $funcionario->Fun_nombre = $request->Fun_nombre;
        $funcionario->Fun_apellido = $request->Fun_apellido;
        $funcionario->save();
        $notificacion = array(
            'mensaje' => 'Funcionario creado con exito',
            'tipo' => 'success',
            'titulo' => 'Funcionario'
        );
        return redirect('funcionario')->with($notificacion);
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
    public function editar($Fun_rut)
    {
        $funcionario = Funcionario::where('Fun_rut', '=', $Fun_rut)
                        ->first();
        return view('funcionario.editar', compact('funcionario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionFuncionario $request, $Fun_rut)
    {
        $funcionario = Funcionario::where('Fun_rut', '=', $Fun_rut)
                               ->first();
        $funcionario->Fun_rut = $request->Fun_rut;
        $funcionario->Fun_dv = $request->Fun_dv;
        $funcionario->Fun_nombre = $request->Fun_nombre;
        $funcionario->Fun_apellido = $request->Fun_apellido;
        $funcionario->update();

        $notificacion = array(
            'mensaje' => 'Funcionario actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Funcionario'
        );
        return redirect('funcionario')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Fun_rut)
    {
        $funcionario = Funcionario::where('Fun_rut', '=', $Fun_rut)
                            ->first();
        if ($request->ajax()) {
            if ($funcionario->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
