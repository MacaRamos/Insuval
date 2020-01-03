<?php

namespace App\Http\Controllers\RecetarioMagistral;

use App\Http\Controllers\Controller;
use App\Models\Articulos\ARTMAEST;
use App\Models\dbFinanzas\AUXILI;
use App\Models\Envase\Envase;
use App\Models\Equipo\Equipo;
use App\Models\FormaFarmaceutica\Preparacion;
use App\Models\Funcionario\Funcionario;
use App\Models\Paciente\Paciente;
use App\Models\Precauciones\Precaucion;
use App\Models\Prescriptor\AUXPRE;
use App\Models\Prescriptor\Prescriptor;
use App\Models\RecetarioMagistral\IDRECETA;
use App\Models\RecetarioMagistral\Receta;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SIC\ADSICTRX;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

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
                ->with(["lineasSIC" => function($q) use($SicLin){
                    $q->where('SicLin', '=', $SicLin);
                }, 'lineasSIC.articulo', 'lineasSIC.formulacion', 'lineasSIC.formulacion.nombreFormulacion'])
                ->with('cliente')
                ->with('paciente')
                ->first();

        // dd($sic);
        $asistentes = Funcionario::where('Fun_tipo', '=', 'AM')
                    ->get();

        $operadores = Funcionario::where('Fun_tipo', '=', 'DT')
        ->orWhere('Fun_tipo', 'like', 'Q%')
        ->get();

        $equipos = Equipo::get();
        $precauciones = Precaucion::get();

        $receta = IDRECETA::where('Id_tipo', '=', 'RM')->first();        
        $receta->Id_numero = $receta->Id_numero + 1;
        $receta->Id_RM = 'RM'.'-'.$receta->Id_numero.'-'.substr($receta->Id_ano,2,4);
        $receta->update();
        
        return view('recetarioMagistral.crear', compact('sic', 'operadores', 'asistentes', 'equipos', 'precauciones', 'receta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarPaciente(Request $request)
    {
        $term = $request->term;

        $queries = Paciente::where('PacNom', 'like', '%'.$term.'%')
        ->take(5)
        ->get();

        return response()->json($queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarPrescriptor(Request $request)
    {
        $term = $request->term;

        $queries = AUXPRE::where('NomPre', 'like', '%'.$term.'%')
        ->take(5)
        ->get();

        return response()->json($queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarEnvase(Request $request)
    {
        $term = $request->term;

        $queries = Envase::where('Env_descripcion', 'like', '%'.$term.'%')
        ->take(5)
        ->get();

        return response()->json($queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarFormaFarmaceutica(Request $request)
    {
        $term = $request->term;

        $queries = Preparacion::where('Pre_descripcion', 'like', '%'.$term.'%')
        ->take(5)
        ->get();

        return response()->json($queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarPrincipioActivo(Request $request)
    {
        $term = $request->term;

        $queries = ARTMAEST::where('art_flag_c', '=','F')
        ->where('Art_nom_ex', 'like', '%'.$term.'%')
        ->take(5)
        ->get();

        return response()->json($queries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        return dd($request->all());
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
