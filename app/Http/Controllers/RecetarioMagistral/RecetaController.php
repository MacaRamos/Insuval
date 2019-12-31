<?php

namespace App\Http\Controllers\RecetarioMagistral;

use App\Http\Controllers\Controller;
use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SIC\ADSICTRX;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recetas = Receta::orderBy('Rec_codigo')->get();
        return view('recetarioMagistral.index', compact('recetas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear($SicFol, $SicLin)
    {
        $sic = ADSICTRX::where('Mb_Epr_cod','=','INS')
                ->where('SicTip','=',2)
                ->Where('SicFol','=',$SicFol)
                ->with(["lineasSIC" => function($q){
                    $q->where('SicLin', '=', 3);
                }, 'lineasSIC.articulo'])
                ->with('cliente')
                ->with('paciente')
                ->first();
        return view('recetarioMagistral.crear', compact('sic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        //
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
    public function editar($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        //
    }
}
