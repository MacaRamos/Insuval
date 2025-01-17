<?php

namespace App\Http\Controllers\SIC;

use App\Http\Controllers\Controller;
use App\Models\Articulos\ARTMAEST;
use App\Models\dbFinanzas\AUXILI;
use App\Models\SIC\ADSICLIN;
use App\Models\SIC\ADSICTRX;
use Illuminate\Http\Request;

class ADSICTRXController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $sics = ADSICTRX::where('Mb_Epr_cod','=','INS')
                ->where('SicTip','=',2)
                ->where('SicAut','=','S')
                ->whereIn('Proc_id', ['C', 'D'])
                ->with('lineasSIC','lineasSIC.articulo', 'lineasSIC.recetas')
                ->with('cliente')
                ->with('paciente')
                ->orderBy('Sic_urgent', 'DESC')
                ->get();
        return view('sic.index', compact('sics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        //
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
