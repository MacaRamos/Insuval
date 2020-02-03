<?php

namespace App\Http\Controllers\Prescriptor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionPrescriptor;
use App\Http\Requests\ValidacionPrescriptor2;
use App\Models\dbFinanzas\AUXILI;
use App\Models\Prescriptor\AUXPRE;
use App\Models\Prescriptor\Prescriptor;
use Illuminate\Http\Request;

class PrescriptorController extends Controller
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
        $prescriptores = AUXPRE::where('NomPre', 'like', "%$filtro%")            
                             ->paginate(15);
        return view('prescriptor.index', compact('prescriptores', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('prescriptor.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionPrescriptor $request)
    {
        $prescriptor = new Prescriptor;
        $prescriptor->PreRUT = $request->PreRUT;
        $prescriptor->PreDV = $request->PreDV;
        $prescriptor->PreNom = $request->PreNom;
        $prescriptor->save();
        $notificacion = array(
            'mensaje' => 'Prescriptor creado con exito',
            'tipo' => 'success',
            'titulo' => 'Prescriptor'
        );
        return redirect('prescriptor')->with($notificacion);
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
    public function editar($IdPre)
    {
        $prescriptor = Prescriptor::where('PreID', '=', $IdPre)
                        ->first();
        
        if(!$prescriptor){
            $auxili = AUXILI::where('Mb_Cod_aux', '=', $IdPre)
                        ->first();
            return view('prescriptor.editarAuxili', compact('auxili'));
        }else{
            return view('prescriptor.editar', compact('prescriptor'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionPrescriptor $request, $PreID)
    {
        $prescriptor = Prescriptor::where('PreID', '=', $PreID)
                               ->first();
        $prescriptor->PacRUT = $request->PacRUT;
        $prescriptor->PacDV = $request->PacDV;
        $prescriptor->NomPre = $request->NomPre;
        $prescriptor->update();

        $notificacion = array(
            'mensaje' => 'Prescriptor actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Prescriptor'
        );
        return redirect('prescriptor')->with($notificacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar2(ValidacionPrescriptor2 $request, $Mb_Cod_aux)
    {
        $auxili = AUXILI::where('Mb_Cod_aux', '=', $Mb_Cod_aux)
                               ->first();
        $auxili->Mb_Cod_aux = $request->PacRUT;
        $auxili->Mb_Dv_aux = $request->Mb_Dv_aux;
        $auxili->Mb_Razon_a = $request->Mb_Razon_a;
        $auxili->update();

        $notificacion = array(
            'mensaje' => 'Prescriptor actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Prescriptor'
        );
        return redirect('prescriptor')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $IdPre)
    {
        $prescriptor = Prescriptor::where('PreID', '=', $IdPre)
                            ->first();
        if($prescriptor){
            if ($request->ajax()) {
                if ($prescriptor->delete()) {
                    return response()->json(['mensaje' => 'ok']);
                } else {
                    return response()->json(['mensaje' => 'ng']);
                }
            } else {
                abort(404);
            }
        }else{
            $auxili = AUXILI::where('Mb_Cod_aux', '=', $IdPre)
                            ->first();
            if ($request->ajax()) {
                if ($prescriptor->delete()) {
                    return response()->json(['mensaje' => 'ok']);
                } else {
                    return response()->json(['mensaje' => 'ng']);
                }
            } else {
                abort(404);
            }
        }
        
    }
}
