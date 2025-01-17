<?php

namespace App\Http\Controllers\RecetarioMagistral;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionReceta;
use App\Models\Articulos\ARTMAEST;
use App\Models\dbFinanzas\AUXILI;
use App\Models\Envase\Envase;
use App\Models\Equipo\Equipo;
use App\Models\Equipo\RECETAEQUIPO;
use App\Models\FormaFarmaceutica\Preparacion;
use App\Models\Funcionario\Funcionario;
use App\Models\Funcionario\RECETAASISTENTE;
use App\Models\MovimientoInventario\EXISMOVC;
use App\Models\MovimientoInventario\EXISTKXL;
use App\Models\MovimientoInventario\EXISTOCK;
use App\Models\MovimientoInventario\EXISTRXC;
use App\Models\MovimientoInventario\EXISTRXL;
use App\Models\MovimientoInventario\PPCENPRO;
use App\Models\Paciente\Paciente;
use App\Models\Precauciones\Precaucion;
use App\Models\Precauciones\RECETAPRECAUCION;
use App\Models\Prescriptor\AUXPRE;
use App\Models\RecetarioMagistral\DETALLERECETA;
use App\Models\RecetarioMagistral\IDRECETA;
use App\Models\RecetarioMagistral\Receta;
use App\Models\SIC\ADSICTRX;
use App\Models\Vencimiento\Vencimiento;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    private $Emp = 'INS';
    private $registrosI15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tipo = '')
    {
        $recetas = Receta::orderBy('Rec_codigo')
            ->with('lineasReceta', 'lineasReceta.articulo')
            ->with('cliente')
            ->with('paciente')
            ->with('formaFarmaceutica')
            ->with('estado')
            ->with('sic')
            ->get();
        if ($tipo == 'producir') 
        {
            $recetas = $recetas->where('Est_codigo', '=', 1);//SOLICITADA
        }
        if ($tipo == 'alta') 
        {
            $recetas = $recetas->where('Est_codigo', '=', 2);//SOLICITADA
        }
        if ($tipo == 'calidad') 
        {
            $recetas = $recetas->where('Est_codigo', '=', 3);//PREPARADA
        }

        // dd($recetas);
        return view('recetarioMagistral.index', compact('recetas', 'tipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear($SicFol, $SicLin)
    {
        $sic = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('SicTip', '=', 2)
            ->Where('SicFol', '=', $SicFol)
            ->with(["lineasSIC" => function ($q) use ($SicLin) {
                $q->where('SicLin', '=', $SicLin);
            }, 'lineasSIC.articulo', 'lineasSIC.formulacion', 'lineasSIC.formulacion.nombreFormulacion'])
            ->with('cliente')
            ->with('paciente')
            ->first();

        $recetasPrimeras = Receta::where('SicTip', '=', 2) //RECETAS HECHAS PARA LA MISMA LINEA, EN CASO DE QUE NO HUBIERAN PREPARADO TODAS LAS UNIDADES
                                 ->Where('SicFol', '=', $SicFol)
                                 ->where('SicLin', '=', $SicLin)
                                 ->get();

        // dd($sic);
        $asistentes = Funcionario::where('Fun_tipo', '=', 'AM')
            ->get();

        $operadores = Funcionario::where('Fun_tipo', '=' , 'DT')
                                 ->OrWhere('Fun_tipo', 'like', 'Q%')
                                 ->get();

        $equipos = Equipo::get();
        $precauciones = Precaucion::get();

        $receta = IDRECETA::where('Id_tipo', '=', 'RM')->first();
        $receta->Id_numero = $receta->Id_numero + 1;
        $receta->Id_RM = 'RM' . '-' . $receta->Id_numero . '-' . substr($receta->Id_ano, 2, 4);
        $receta->update();

        $vencimientos = Vencimiento::get();

        return view('recetarioMagistral.crear', compact('sic', 'operadores', 'asistentes', 'equipos', 'precauciones', 'receta', 'vencimientos', 'recetasPrimeras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarPaciente(Request $request)
    {
        $term = $request->term;

        $queries = Paciente::where('PacNom', 'like', '%' . $term . '%')
            ->take(5)
            ->get();

        return response()->json($queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarCliente(Request $request)
    {
        $term = $request->term;

        $queries = AUXILI::where('Mb_Razon_a', 'like', '%' . $term . '%')
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

        $queries = AUXPRE::where('NomPre', 'like', '%' . $term . '%')
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

        $queries = Envase::where('Env_descripcion', 'like', '%' . $term . '%')
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

        $queries = Preparacion::where('Pre_descripcion', 'like', '%' . $term . '%')
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

        $queries = ARTMAEST::where('art_flag_c', '=', 'F')
            ->where('Art_nom_ex', 'like', '%' . $term . '%')
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
    public function guardar(ValidacionReceta $request)
    {
        $receta = new Receta;
        $receta->Mb_Epr_cod = $this->Emp;
        $receta->SicTip = 2;
        $receta->Rec_codigo = $request->Rec_codigo;
        $receta->SicFol = $request->SicFol;
        $receta->SicLin = $request->SicLin;
        $receta->Pre_codigo = $request->Pre_codigo;
        $receta->Fun_quimico = $request->Fun_quimico;
        $receta->Rec_cantidad = $request->Rec_cantidad;
        $receta->Rec_unidades = $request->Rec_unidades;
        $receta->Rec_indicacion = $request->Rec_indicacion;
        $receta->Rec_tipo = $request->Rec_tipo;
        $receta->Rec_fechaPreparacion = $request->Rec_fechaPreparacion;
        $receta->Rec_fechaVencimiento = $request->Rec_fechaVencimiento;
        $receta->PrincipioActivo = $request->PrincipioActivo;
        $receta->NombrePrincipio = $request->NombrePrincipio;
        $receta->Cliente = $request->Mb_Cod_aux;
        $receta->IdPre = $request->IdPre;
        $receta->PacID = $request->PacID;
        $receta->Rec_modoPreparacion = $request->Rec_modoPreparacion;
        $receta->Rec_detalleTipo = $request->Rec_detalleTipo;
        $receta->Rec_organolepticas = $request->Rec_organolepticas;
        $receta->Est_codigo = 1;//SOLICITADA
        $receta->Ven_codigo = $request->Ven_codigo;
        $receta->save();

        if (is_null($request->item) == false) {
            foreach ($request->item as $key => $item) {
                $detalleReceta = new DETALLERECETA;
                $detalleReceta->Mb_Epr_cod = $this->Emp;
                $detalleReceta->Rec_codigo = $request->Rec_codigo;
                $detalleReceta->Drec_item = $item;
                $detalleReceta->Art_cod = $request->componenteCodigo[$key];
                $detalleReceta->Drec_cantidad = $request->cantidad[$key];
                $detalleReceta->Um_codigo = $request->unmedida[$key];
                $detalleReceta->Drec_porcentaje = $request->porcentaje[$key];
                $detalleReceta->save();
            }
        }

        if (is_null($request->asistentes) == false) {
            foreach ($request->asistentes as $asistente) {
                $recetaAsistente = new RECETAASISTENTE;
                $recetaAsistente->Mb_Epr_cod = $this->Emp;
                $recetaAsistente->Rec_codigo = $request->Rec_codigo;
                $recetaAsistente->Fun_rut = $asistente;
                $recetaAsistente->save();
            }
        }

        if (is_null($request->equipos) == false) {
            foreach ($request->equipos as $equipo) {
                $recetaEquipo = new RECETAEQUIPO;
                $recetaEquipo->Mb_Epr_cod = $this->Emp;
                $recetaEquipo->Rec_codigo = $request->Rec_codigo;
                $recetaEquipo->Equ_codigo = $equipo;
                $recetaEquipo->save();
            }
        }

        if (is_null($request->precauciones) == false) {
            foreach ($request->precauciones as $precaucion) {
                $recetaPrecaucion = new RECETAPRECAUCION;
                $recetaPrecaucion->Mb_Epr_cod = $this->Emp;
                $recetaPrecaucion->Rec_codigo = $request->Rec_codigo;
                $recetaPrecaucion->Cau_codigo = $precaucion;
                $recetaPrecaucion->save();
            }
        }

        $SicLin = $request->SicLin;
        $sic = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('SicTip', '=', 2)
            ->Where('SicFol', '=', $request->SicFol)
            ->with(["lineasSIC" => function ($q) use ($SicLin) {
                $q->where('SicLin', '=', $SicLin);
            }, 'lineasSIC.recetas'])
            ->first();
        
        $sic->Proc_id = 'D';//EN PRODUCCIÓN
        $sic->update();
        // if ($sic->lineasSIC[0]->recetas->sum('Rec_unidades') == intval($sic->lineasSIC[0]->SicArtCan)) {
            
        //     $lineas = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
        //         ->where('SicTip', '=', 2)
        //         ->Where('SicFol', '=', $request->SicFol)
        //         ->with('lineasSIC', 'lineasSIC.recetas')
        //         ->first();
            
        //     $lineasListas = true;
        //     foreach ($lineas->lineasSIC as $linea) {
        //         if ($linea->recetas->sum('Rec_unidades') != intval($linea->SicArtCan,0)) {
        //             $lineasListas = false;
        //         }
        //     }
        //     if ($lineasListas){

        //     }
        // }

        $notificacion = array(
            'mensaje' => 'Receta creada con éxito',
            'tipo' => 'success',
            'titulo' => 'Receta'
        );

        return redirect('sic')->with($notificacion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function altaCalidad($Rec_codigo, $Rec_fechaVencimiento, $button)
    {
        if ($button == 'producir') {
            $receta = Receta::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Rec_codigo', '=', $Rec_codigo)
                ->first();
            $receta->Est_codigo = '2';//EN PRODUCCION
            $receta->update();
            $notificacion = array(
                'mensaje' => 'Receta enviada a producción con éxito',
                'tipo' => 'info',
                'titulo' => 'Receta',
            );
    
            return redirect('recetarioMagistral/receta/producir')->with($notificacion);
        }
        if ($button == 'alta') {
            $cod_mov = 'I15';
            $registrosI15 = $this->movimientoI15($Rec_codigo, $Rec_fechaVencimiento, $cod_mov);
            
            
            $receta = Receta::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Rec_codigo', '=', $Rec_codigo)
                ->with('formulacion')
                ->get();
            $receta[0]->Est_codigo = '3';//Preparada
            $receta[0]->update();
            $this->rebajandoMateriales($registrosI15, $receta);
            $notificacion = array(
                'mensaje' => 'Receta dada de alta con éxito',
                'tipo' => 'info',
                'titulo' => 'Receta',
            );
    
            return redirect('recetarioMagistral/receta/alta')->with($notificacion);
        }
        if ($button == 'calidad') {

            /* Paso final: Cambiar estado de control de calidad a la receta: Rec_calidad = 'S' */
            $receta = Receta::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Rec_codigo', '=', $Rec_codigo)
                ->with('sic', 'sic.lineasSIC')
                ->first();
            $receta->Est_codigo = 4;//APROBADA
            $receta->update();


            $lineasListas = true;
            foreach ($receta->sic->lineasSIC as $linea) {
                if ($linea->recetas->sum('Rec_unidades') != intval($linea->SicArtCan,0)) {
                    $lineasListas = false;
                }
            }
            if ($lineasListas){
                $receta->sic->Proc_id = 'E';//EN CONTROL DE CALIDAD
                $receta->sic->update();
            }
            /* Fin Paso final */
            $notificacion = array(
                'mensaje' => 'Receta aprobada con éxito',
                'tipo' => 'info',
                'titulo' => 'Receta',
            );
    
            return redirect('recetarioMagistral/receta/calidad')->with($notificacion);
        }

    }

    private function obtenerFolio($cod_mov)
    {
        /* Paso 1: Obtener Folio Movimiento: MOV_FOLIO y aumentar en 1 Mov_serie */
        $movimiento = EXISMOVC::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ex_mov_cod', '=', $cod_mov)
            ->first();
        $Mov_serie = $movimiento->Mov_serie + 1;
        $movimiento->Mov_serie += 1;
        $movimiento->update();
        return $Mov_serie;
        /* Fin */
    }
    private function movimientoI15($Rec_codigo, $Rec_fechaVencimiento, $cod_mov)
    {
        /* Definiendo variables */
        $EX_OBS1 = 'PRODUCTO TERMINADO';
        $cod_centro = 'RMA';
        $Sede = 1;

        /* Fin */
        /* Paso 1: Obtener Folio para I15 */
        $Mov_serie = $this->obtenerFolio($cod_mov);
        /* Fin Paso 1 */

        /* Paso 2: Obtener datos de receta y SIC */
        $datos = Receta::where('Rec_codigo', '=', $Rec_codigo)
            ->where('Mb_Epr_cod', '=', $this->Emp)
            ->with('formaFarmaceutica')
            ->with('formulacion')
            ->with('sic')
            ->with('sic.cliente')
            ->first();
        $costoFomula = 0;
        foreach ($datos->formulacion as $item) {
            $costoFomula = $costoFomula + ($item->Gc_cant * $item->Gc_for_cst);
        }
        /* Fin Paso 2 */

        /* Paso 3 Obtener Nombre Centro */
        $cen_nom = PPCENPRO::select('pp_cen_nom')->where('pp_epr_cod', '=', $this->Emp)
            ->where('pp_cen_id', '=', $cod_centro)
            ->first();
        /* Fin Paso 3 */

        /* Paso 4: Agregar Registros a EXISTRXC y EXISTRXL */
        $existrxc = new EXISTRXC;
        $existrxc->MOV_FOLIO = $Mov_serie;
        $existrxc->Ex_mov_cod = $cod_mov;
        $existrxc->Mb_Epr_cod = $this->Emp;
        $existrxc->MOV_STATUS = 'A';
        $existrxc->MOV_FECHA = date("d/m/Y");
        $existrxc->MOV_HORA = date("H:i:s");
        $existrxc->ex_oc_foli = 0;
        $existrxc->Ex_recde = '';
        $existrxc->Ex_patente = '';
        $existrxc->Mb_Tip_Doc = 'TI';
        $existrxc->EX_NRODOCT = $existrxc->MOV_FOLIO;
        $existrxc->Ex_recpor = '';
        $existrxc->EX_OBS1 = $EX_OBS1; //'';
        $existrxc->EX_OBS2 = '';
        $existrxc->EX_ESTDOC = 'C';
        $existrxc->EX_ESTPRT = 'N';
        $existrxc->ex_fecanul = null;
        $existrxc->EX_INDANUL = 'N';
        $existrxc->EX_ULTLI = 1;
        $existrxc->EX_TOTPQT = 0;
        $existrxc->EX_TOTPIE = 0;
        $existrxc->EX_TOTVOL = 0;
        $existrxc->EX_OPE = 0;
        $existrxc->EX_TRECEP = '';
        $existrxc->EX_TSERV = 0;
        $existrxc->EX_TMAD = '';
        $existrxc->EX_PCONTRO = 0;
        $existrxc->EX_TURNO = '';
        $existrxc->EX_TRATERO = 0;
        $existrxc->EX_NCARGA = 0;
        $existrxc->EX_RPROV = 0;
        $existrxc->Mov_Turno = '';
        $existrxc->Ex_gd_orig = 0;
        $existrxc->Ex_np_foli = 0;
        $existrxc->Ex_np_fech = null;
        $existrxc->Ex_np_clie = '';
        $existrxc->Bod_destin = 3;
        $existrxc->Ubi_destin = '';
        $existrxc->Ex_con_fol = 0;
        $existrxc->Ex_con_fec = null;
        $existrxc->Mov_gd_fol = 0;
        $existrxc->EX_SOLPOR = '';
        $existrxc->ex_estfac = '';
        $existrxc->ex_indfac = '';
        $existrxc->EX_ORPROD = '';
        $existrxc->Ve_np_tipo = '';
        $existrxc->Ve_np_foli = 0;
        $existrxc->Mb_cor_dir = 0;
        $existrxc->mov_rut_cl = 0;
        $existrxc->mov_nro_ru = 0;
        $existrxc->EX_SEDE = $Sede;
        $existrxc->EX_BODSEDE = 3; //&EX_BODSEDE;
        $existrxc->EX_BODDESC = '';
        $existrxc->ex_cod_aux = $datos->Cliente;
        $existrxc->ex_cod_dv = $datos->sic->cliente->Mb_Dv_aux;
        $existrxc->ex_cod_raz = $datos->sic->cliente->Mb_Razon_a;
        $existrxc->ex_trx_cos = 'S';
        $existrxc->ex_bde_des = '';
        $existrxc->ex_bde_dir = '';
        $existrxc->ex_bde_ciu = '';
        $existrxc->ex_tipo_de = '';
        $existrxc->ex_fac_nro = 0;
        $existrxc->ex_trx_fec = date("d/m/Y");
        $existrxc->ex_trx_hor = date("H:i:s");
        $existrxc->ex_trx_utr = session()->get('Usu_usuario');
        $existrxc->ex_trx_tip = 'A';
        $existrxc->ex_trx_mon = '';
        $existrxc->ex_trx_cam = 0;
        $existrxc->ex_trx_fob = 0;
        $existrxc->ex_trx_fle = 0;
        $existrxc->ex_trx_seg = 0;
        $existrxc->ex_trx_cif = 0;
        $existrxc->ex_trx_vad = 0;
        $existrxc->ex_trx_vap = 0;
        $existrxc->ex_trx_adu = '';
        $existrxc->Ex_NumOC = 0;
        $existrxc->pp_cen_id = $cod_centro;
        $existrxc->pp_sce_id = 0;
        $existrxc->ex_num_ord = $datos->sic->SicFol;
        $existrxc->ex_num_oc = $datos->sic->SicPOnro;
        $existrxc->ex_cen_nom = $cen_nom->pp_cen_nom;
        $existrxc->ex_sce_nom = '';
        $existrxc->pp_tur_id = 'A';
        $existrxc->pp_ope_id = session()->get('Usu_usuario');
        $existrxc->pp_cli_fin = '';
        $existrxc->pp_fic_cl = '';
        $existrxc->pp_proc_id = '';
        $existrxc->save();

        $existrxl = new EXISTRXL;
        $existrxl->MOV_FOLIO = $Mov_serie;
        $existrxl->Ex_mov_cod = $cod_mov;
        $existrxl->Mb_Epr_cod = $this->Emp;
        $existrxl->EX_LINEA = 1;
        $existrxl->Art_cod = $datos->PrincipioActivo;
        $existrxl->Ex_art_es = 0;
        $existrxl->Ex_art_an = 0;
        $existrxl->Ex_art_la = 0;
        $existrxl->Ex_art_al = 0;
        $existrxl->Ex_art_am = 0;
        $existrxl->Ex_art_Cpa = '';
        $existrxl->Ex_art_Ta = '';
        $existrxl->Ex_art_Pie = 0;
        $existrxl->MOV_ART_CA = $datos->Rec_unidades;
        $existrxl->MOV_ART_UM = $datos->formaFarmaceutica->Pre_unidadMedida;
        $existrxl->MOV_ART_VA = $costoFomula;
        $existrxl->BOD_EXIS = 3;
        $existrxl->Mov_ubi_co = 'EXI';
        $existrxl->Mov_Art_Pi = 0;
        $existrxl->Mov_art_Bo = '';
        $existrxl->ex_congast = 0;
        $existrxl->Mov_art_si = '+';
        $existrxl->ex_transf = 0;
        $existrxl->ex_ultrans = 0;
        $existrxl->Ex_art_bar = '';
        $existrxl->mov_art_tc = ($existrxl->MOV_ART_CA * $existrxl->MOV_ART_VA);
        $existrxl->costo_avg_ = 0;
        $existrxl->stock_art_ = 0;
        $existrxl->valor_bod_ = 0;
        $existrxl->art_avg_nu = 0;
        $existrxl->mov_art_pr = 0;
        $existrxl->mov_art_pl = 0;
        $existrxl->mov_art_sp = 0;
        $existrxl->mov_art_cb = '';
        $existrxl->art_ulinea = 0;
        $existrxl->mov_art_or = 0;
        $existrxl->mov_art_de = '';
        $existrxl->Art_Stk_Fi = null;
        $existrxl->Art_Fec_Vc = $Rec_fechaVencimiento; //PREGUNTAR A DON CARLOS / YA LE PREGUNTE A DON CARLOS Y DIGO QUE ERA $Rec_fechaVencimiento
        $existrxl->art_lote = $Rec_codigo; //PREGUNTAR A DON CARLOS / YA LE PREGUNTÈ Y DIJO QUE ERA LA REC_CODIGO SIN EL RM
        $existrxl->art_trx_td = '';
        $existrxl->art_trx_no = 0;
        $existrxl->save();

        return array($existrxc, $existrxl);
        /* Fin Paso 4 */
    }


    private function rebajandoMateriales($registrosI15, $receta)
    {
        $cod_mov = 'D15';
        $Mov_serie = $this->obtenerFolio($cod_mov);
        $existrxc = new EXISTRXC;
        $existrxc->Mb_Epr_cod = $this->Emp;
        $existrxc->MOV_FOLIO = $Mov_serie;
        $existrxc->Ex_mov_cod = 'D15';
        $existrxc->MOV_FECHA = $registrosI15[0]->MOV_FECHA;
        $existrxc->MOV_HORA = date("H:i:s");
        $existrxc->EX_ESTDOC = 'D';
        $existrxc->EX_ESTPRT = 'N';
        $existrxc->MOV_STATUS = 'A';
        $existrxc->Mb_Tip_Doc = 'TI';
        $existrxc->EX_NRODOCT = $registrosI15[0]->EX_NRODOCT;
        $existrxc->EX_OBS1 = 'REBAJA COMPONENTES';
        $existrxc->EX_OBS2 = 'REBAJA COMPONENTES';
        $existrxc->Bod_destin = 5;
        $existrxc->EX_INDANUL = 'N';
        $existrxc->Mov_gd_fol = $registrosI15[0]->EX_NRODOCT;
        $existrxc->EX_SEDE = $registrosI15[0]->EX_SEDE;
        $existrxc->EX_BODSEDE = 5; //&BodegaOrigen
        $existrxc->ex_trx_hor = date("H:i:s");
        $existrxc->ex_trx_fec = date("d/m/Y");
        $existrxc->ex_trx_utr = session()->get('Usu_usuario');
        $existrxc->save();

        foreach ($receta[0]->formulacion as $key => $item) {
            $cantidad = $registrosI15[1]->MOV_ART_CA * $item->Gc_cant;
            $existock = EXISTOCK::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Ex_art_cod', '=', $item->Gc_art2)
                ->where('Ex_bod_cod', '=', $registrosI15[0]->EX_BODSEDE)
                ->where('Ex_ubi_cod', '=', 'EXI')
                ->first();

            if ($existock) {
                $existock->Stock_actu = $existock->Stock_actu - $cantidad;
                $existock->update();
            } else {
                $existock = new EXISTOCK;
                $existock->Mb_Epr_cod = $this->Emp;
                $existock->Ex_bod_cod = $registrosI15[0]->EX_BODSEDE; //bodega por defecto de la transaccion
                $existock->Ex_ubi_cod = 'EXI'; //ubicacion por defecto de la bodega ventas
                $existock->Ex_art_cod = $item->Gc_art2;
                $existock->Stock_actu = $cantidad * -1;
                $existock->save();
            }
            $existrxl = new EXISTRXL;
            $existrxl->Mb_Epr_cod = $this->Emp;
            $existrxl->MOV_FOLIO = $Mov_serie;
            $existrxl->Ex_mov_cod = 'D15';
            $existrxl->EX_LINEA = $key + 1;
            $existrxl->Art_cod = $item->Gc_art2;
            $existrxl->MOV_ART_CA = $cantidad;
            $existrxl->MOV_ART_VA = $item->Gc_for_cst; //Traer de EXISSTOCK   REVISAR
            $existrxl->mov_art_tc = $existrxl->MOV_ART_CA * $existrxl->MOV_ART_VA;
            $existrxl->MOV_ART_UM = 'UN';
            $existrxl->BOD_EXIS = $registrosI15[0]->EX_BODSEDE;
            $existrxl->Mov_ubi_co = 'EXI';
            $existrxl->Ex_art_bar = $registrosI15[1]->Art_cod;
            $existrxl->mov_art_de = $registrosI15[1]->articulo()->first()->Art_nom_ex;
            $existrxl->save();
        }
        $existrxc->EX_ESTDOC = 'C';
        $existrxc->update();

    }

    public function imprimirEtiqueta($Rec_codigo, $button)
    {
        $receta = Receta::where('Rec_codigo', '=', $Rec_codigo)
            ->where('Mb_Epr_cod', '=', $this->Emp)
            ->with('paciente', 'prescriptor',
                'formaFarmaceutica', 'operador',
                'precauciones.precaucion', 'sic',
                'vencimiento', 'formulacion',
                'formulacion.nombreFormulacion',
                'asistentes', 'asistentes.funcionario')
            ->first();

        $asistentes = array();
        foreach ($receta->asistentes as $asistente) {
            $nombreAsistente = $asistente->funcionario->Fun_nombre;
            $nombreAsistente = explode(" ", $nombreAsistente);
            $apellidoAsistente = $asistente->funcionario->Fun_apellido;
            $apellidoAsistente = explode(" ", $apellidoAsistente);
            $nombreCompleto = $nombreAsistente[0] . ' ' . $apellidoAsistente[0];
            array_push($asistentes, $nombreCompleto);
        }
        $asistentes = implode(", ", $asistentes);

        $ditec = Funcionario::where('Fun_tipo', '=', 'DT')->first();

        $nombreDitec = trim(strtoupper($ditec->Fun_nombre));
        $nombreDitec = explode(" ", $nombreDitec);
        $apellidoDitec = trim(strtoupper($ditec->Fun_apellido));
        $apellidoDitec = explode(" ", $apellidoDitec);
        $ditec = $nombreDitec[0] . ' ' . $apellidoDitec[0] . ' ' . substr($apellidoDitec[1], 0, 1) . '.';

        $nombreOperador = trim(strtoupper($receta->operador->Fun_nombre));
        $nombreOperador = explode(" ", $nombreOperador);
        $apellidoOperador = trim(strtoupper($receta->operador->Fun_apellido));
        $apellidoOperador = explode(" ", $apellidoOperador);
        $operador = $nombreOperador[0] . ' ' . $apellidoOperador[0] . ' ' . substr($apellidoOperador[1], 0, 1) . '.';

        if ($button == 'imprimir') {
            $precauciones = array();
            foreach ($receta->precauciones as $item) {
                array_push($precauciones, trim($item->precaucion[0]->Cau_descripcion));
            }
            $precauciones = implode(",", $precauciones);

            $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <etiqueta>
                <encabezado>
                    <paciente>' . trim(strtoupper($receta->paciente->PacNom)) . '</paciente>
                    <prescriptor>' . trim(strtoupper($receta->prescriptor->NomPre)) . '</prescriptor>
                </encabezado>
                <cuerpo>
                    <indicacion>' . trim(strtoupper($receta->Rec_indicacion)) . '</indicacion>
                    <cantidad>' . $receta->Rec_cantidad . ' ' . trim($receta->formaFarmaceutica->Pre_unidadMedida) . '</cantidad>
                    <principioactivo>' . trim(strtoupper($receta->NombrePrincipio)) . '</principioactivo>
                    <fechapreparacion>' . date('d-m-Y', strtotime($receta->Rec_fechaPreparacion)) . '</fechapreparacion>
                    <fechavencimiento>' . date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)) . '</fechavencimiento>
                    <directortecnico>' . $operador . '</directortecnico>
                    <precauciones>' . $precauciones . '</precauciones>
                    <numeroreceta>' . trim($receta->Rec_codigo) . '</numeroreceta>
                </cuerpo>
            </etiqueta>';

            $textoXML = mb_convert_encoding($xml, "UTF-8");

            $client = new Client();

            // &HTTPClient.Host = 'leviatan-01'
            // &HTTPClient.Port = 80
            $url = "http://leviatan-01/InsuvalLabelService/json.rpc";

            $response = $client->request('POST', $url, [
                'headers' => ['content-type' => 'application/json-rpc'],
                'json' => ['method' => 'print.printLabel',
                    'params' => [
                        'ZDesigner GT800 (EPL)',
                        'recetariomagistral.pml',
                        base64_encode($textoXML),
                    ]],
            ]);

            $code = $response->getStatusCode();
            if ($code == 200) {
                //tuvo una respuesta positiva del servidor, ahora hay que revisar si se imprimio o no
                return redirect('recetarioMagistral/receta')->with('mensaje', 'La etiqueta se ha impreso correctamente');
            } else {
                //respuesta negativa
                //error 500: un error inesperado que ha provocado que el servicio se bugee
                //error 404: la url está incorrecta
                //otros errores: ni idea
                return redirect('recetarioMagistral/receta')->with('mensaje', $response);
            }
        }
        if ($button == 'reporte') {
            //dd($receta);
            $pdf = \PDF::loadView('reportes.reporteReceta', compact('receta', 'ditec', 'operador', 'asistentes'));
            return $pdf->stream();
        }
    }

    public function libroPreparaciones(Request $request){
        $fechaInicio = explode(' - ', $request->rangoFecha)[0];
        $fechaTermino = explode(' - ', $request->rangoFecha)[1];

        $recetas = Receta::where('Mb_Epr_cod', '=', $this->Emp)
                         ->where('Rec_fechaPreparacion', '>=', $fechaInicio)
                         ->where('Rec_fechaPreparacion', '<=', $fechaTermino)
                         ->with('paciente', 'prescriptor', 
                         'formaFarmaceutica', 'operador', 
                         'precauciones.precaucion', 'sic', 
                         'vencimiento', 'formulacion',
                         'formulacion.nombreFormulacion',
                         'asistentes', 'asistentes.funcionario')
                         ->get();
        
        $pdf = \PDF::loadView('reportes.libroPreparaciones', compact('recetas'));
        return $pdf->stream();
    }

    public function libroRecetas(Request $request){
        $fechaInicio = explode(' - ', $request->rangoFecha)[0];
        $fechaTermino = explode(' - ', $request->rangoFecha)[1];

        $recetas = Receta::where('Mb_Epr_cod', '=', $this->Emp)
                         ->where('Rec_fechaPreparacion', '>=', $fechaInicio)
                         ->where('Rec_fechaPreparacion', '<=', $fechaTermino)
                         ->with(['lineasReceta', 'lineasReceta.articulo'])
                         ->with('paciente', 'prescriptor', 
                         'formaFarmaceutica', 'operador', 
                         'precauciones.precaucion', 'sic', 
                         'vencimiento', 'formulacion',
                         'formulacion.nombreFormulacion',
                         'asistentes', 'asistentes.funcionario')
                         ->get();

        $pdf = \PDF::loadView('reportes.libroRecetas', compact('recetas'))->setOrientation('landscape');
        return $pdf->stream();
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
     *     * @param  \Illuminate\Http\Request  $request
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
