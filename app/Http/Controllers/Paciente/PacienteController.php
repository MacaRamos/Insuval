<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionPaciente;
use App\Models\Paciente\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->buscarpor);
        $filtro = $request->get('buscarpor');
        $pacientes = Paciente::where('PacNom', 'like', "%$filtro%")            
                             ->paginate(15);
        return view('paciente.index', compact('pacientes', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('paciente.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionPaciente $request)
    {
        $paciente = new Paciente;
        $paciente->PacRUT = $request->PacRUT;
        $paciente->PacDV = $request->PacDV;
        $paciente->PacNom = $request->PacNom;
        $paciente->save();
        $notificacion = array(
            'mensaje' => 'Paciente creado con exito',
            'tipo' => 'success',
            'titulo' => 'Paciente'
        );
        return redirect('paciente')->with($notificacion);
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
    public function editar($PacID)
    {
        $paciente = Paciente::where('PacID', '=', $PacID)
                        ->first();
        return view('paciente.editar', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionPaciente $request, $PacID)
    {
        $paciente = Paciente::where('PacID', '=', $PacID)
                               ->first();
        $paciente->PacRUT = $request->PacRUT;
        $paciente->PacDV = $request->PacDV;
        $paciente->PacNom = $request->PacNom;
        $paciente->update();

        $notificacion = array(
            'mensaje' => 'Paciente actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Paciente'
        );
        return redirect('paciente')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $PacID)
    {
        $paciente = Paciente::where('PacID', '=', $PacID)
                            ->first();
        if ($request->ajax()) {
            if ($paciente->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
