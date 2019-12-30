<?php

namespace App\Http\Controllers\SIC;

use App\Http\Controllers\Controller;
use App\Models\Articulos\ARTMAEST;
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
                ->where('Proc_id','=','C')
                ->with('lineasSIC')
                ->get();
        
        foreach($sics as $sic){
            dd($sic->SicLin);
        }
        //return view('sic.index', compact('sics', 'lineas'));
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
