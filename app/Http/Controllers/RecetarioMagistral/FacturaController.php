<?php

namespace App\Http\Controllers\RecetarioMagistral;

use App\Http\Controllers\Controller;
use App\Models\Cliente\CLIDEFIN;
use App\Models\Factura\CLICARTO;
use App\Models\Factura\EMPRES;
use App\Models\Factura\SEDES;
use App\Models\Factura\VETRXCAB;
use App\Models\Factura\VETRXLIN;
use App\Models\Factura\VETRXPAR;
use App\Models\Seguridad\TSEG02;
use App\Models\SIC\ADSICTRX;
use App\Models\MedioPago\VEFPADEF;
use DateTime;
use DOMDocument;
use Illuminate\Http\Request;
use SimpleXMLElement;

class FacturaController extends Controller
{
    private $Emp = 'INS';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sics = '')
    {
        $filtro = $request->get('buscarpor');
        $sics = ADSICTRX::where('Mb_Epr_cod','=','INS')
                        ->where('SicTip','=',2)
                        ->where(strval('SicFol'),'like', "%$filtro%")
                        ->Orwhere(strval('SicPOnro'),'like', "%$filtro%")
                        ->where('SicAut','=','S')
                        ->where('Proc_id','=','C')
                        ->with('lineasSIC')
                        ->with('lineasSIC.articulo')
                        ->with('cliente')
                        ->with('paciente')
                        ->get();            
                
        return view('recetarioMagistral.factura.index', compact('sics', 'request'));
    }

    public function facturar($SicFol){
        $vetrxpar = VETRXPAR::where('Mb_Epr_cod', '=', $this->Emp)
                           ->where('Mb_Sedecod', '=', 9999)
                           ->where('gc_caja_co', '=', 99)
                           ->first();
        $fac_nro = $vetrxpar->gc_fac_nro + 1;//FACTURA
        $vetrxpar->gc_fac_nro = $vetrxpar->gc_fac_nro + 1;
        $bol_nro = $vetrxpar->gc_bol_nro + 1;//NTRX
        $vetrxpar->gc_bol_nro = $vetrxpar->gc_bol_nro + 1;
        $vetrxpar->update();
        /* lo dejo en una variable por si cambia en el futuro */
        $IVA = 19;
        $sede = 1;
        $tipoDocto = 'FA';
        $dpto = 'V'.$sede;
        $tipcli = 'M';
        /* fin */

        $tseg02 = TSEG02::where('Seg_usuari','=',session()->get('Usu_usuario'))
                    ->with('cajero')
                    ->first();

        $sic = ADSICTRX::where('Mb_Epr_cod','=','INS')
                        ->where('SicTip','=',2)
                        ->where(strval('SicFol'),'=', "$SicFol")
                        ->where('SicAut','=','S')
                        ->where('Proc_id','=','C')
                        ->with(["lineasSIC" => function ($q){
                            $q->where('LineReady', '=', 1);
                        }, 'lineasSIC.articulo', 'lineasSIC.stock'])
                        ->with('cliente')
                        ->with('clidefin')
                        ->with('clidefin.formaPago')
                        ->with('paciente')
                        ->with('direccion')
                        ->first();
        
        $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        $vetrxcab = new VETRXCAB();
        $vetrxcab->Mb_Epr_cod = $this->Emp;
        $vetrxcab->Ve_bol_nro = $bol_nro;
        $vetrxcab->Ve_bol_dep = $dpto;
        $vetrxcab->ve_bol_tip = $tipoDocto;  //cambiar a parametro por tipo documento
        $vetrxcab->Ve_Cod_Cli = $sic->Ve_Cod_Cli;
        $vetrxcab->Ve_bol_ven = $sic->SicVend;
        $vetrxcab->Ve_bol_fec = date("d/m/Y");    // poner fecha contable mes abierto
        $vetrxcab->Ve_bol_nul = 'N';
        $vetrxcab->Ve_bol_ing = date("d/m/Y");
        $vetrxcab->Ve_bol_cog = 'N';
        $vetrxcab->Ve_bol_rem = 'N';
        $vetrxcab->ve_trx_sem = $dias[date("w")];
        $vetrxcab->Ve_bol_sed = $sede;
        $vetrxcab->Ve_bol_par = 1;
        $vetrxcab->Ve_bol_mon = 'PE';
        $vetrxcab->Ve_bol_exe = 'N';
        $vetrxcab->ve_trx_ob1 = 'FACTURA SIC Nº: '.$sic->SicFol;
        $vetrxcab->ve_bol_uli = 0;
        $vetrxcab->ve_trx_tot = 0;
        $vetrxcab->ve_trx_imp = 0;
        $vetrxcab->ve_trx_iva = 0;
        $vetrxcab->ve_trx_net = 0;
        $vetrxcab->ve_trx_imp = 0;
        $vetrxcab->ve_trx_ob2 = 'ESTADO INICIAL';
        $vetrxcab->ve_trx_no = $fac_nro;
        $vetrxcab->ve_trx_dia = $dias[date("w")];
        $vetrxcab->ve_trx_hor = date("H:i:s");
        $vetrxcab->Ve_bol_dum = 0;
        $vetrxcab->Ve_bol_mto = 0;
        $vetrxcab->Ve_bol_miv = 0;
        $vetrxcab->ve_bol_pos = session()->get('Usu_usuario');
        $vetrxcab->ve_bol_npo = $tseg02->Seg_NPos;
        $vetrxcab->ve_pos_cie = 'N';
        $vetrxcab->ve_pos_caj = $tseg02->cajero->Te_Caj_Cod;
        $vetrxcab->ve_trx_noc = $sic->SicFol;     //Folio de SIC se toma como Orden de Compra
        $vetrxcab->ve_trx_fve = date("d/m/Y",strtotime(date("d-m-Y")."+ ".$sic->clidefin->formaPago->Ve_tds_pag." days"));
        $vetrxcab->ve_trx_dfa = $sic->Sicdircli;
        $vetrxcab->ve_red_tip = $tipcli;        
        $vetrxcab->ve_trx_fob = $sic->direccion->Mb_dir_Aux;
        $vetrxcab->ve_trx_noc = $sic->SicFol;
        $vetrxcab->ve_trx_nfa = $sic->SicFol;
        $vetrxcab->ve_trx_sic = $sic->SicFol;
        $vetrxcab->ve_cli_nom = $sic->cliente->Mb_Razon_A;
        $vetrxcab->ve_trx_tiv = $IVA;
        $vetrxcab->ve_trx_fim = 'N';
        $vetrxcab->ve_trx_fpa = $sic->clidefin->formaPago->Ve_tnom_pa;
        $vetrxcab->ve_trx_sti = $sic->SicTip;
        $vetrxcab->save();
        
  
        foreach($sic->lineasSIC as $key => $linea){
            $vetrxlin = new VETRXLIN;
            $vetrxlin->Mb_Epr_cod = $this->Emp;
            $vetrxlin->Ve_bol_nro = $bol_nro;
            $vetrxlin->Ve_bol_dep = $dpto;
            $vetrxlin->ve_bol_tip = $tipoDocto;  //cambiar a parametro por tipo documento
            $vetrxlin->Ve_bol_art = $linea->Art_cod;
            $vetrxlin->ve_bol_cba = $linea->Art_cod_la;
            $vetrxlin->ve_art_des = $linea->articulo->Art_nom_ex;
            $vetrxlin->Ve_bol_bod = $sede;
            $vetrxlin->Ve_bol_ubi = 'EXI';
            $vetrxlin->Ve_bol_um = 'UN';
            $vetrxlin->Ve_bol_can = $linea->SicArtCan;
            $vetrxlin->ve_bol_pnu = $linea->Sicartval;  
            $vetrxlin->Ve_bol_pre = round($linea->Sicartval*(1+($IVA/100)));
            $vetrxlin->Ve_bol_lde = 0;
            $vetrxlin->ve_trx_prc = $linea->Sicartval;
            $vetrxlin->ve_trx_sli = $linea->SicArtCan * $linea->Sicartval;
            $vetrxlin->Ve_bol_lto = $linea->SicArtCan * round($linea->Sicartval*(1+($IVA/100)));
            $vetrxlin->ve_bol_nli = $key+1;
            $vetrxlin->ve_bol_cba = $linea->Art_cod_la;
            $vetrxlin->ve_bol_fam = $linea->Gc_fam_cod;
            $vetrxlin->ve_bol_fde = $linea->Gc_fam_des;
            $vetrxlin->ve_bol_cla = $linea->Gc_cla_cod;
            $vetrxlin->ve_bol_cde = $linea->Gc_cla_des;
            $vetrxlin->ve_trx_fec = date("d/m/Y");
            $vetrxlin->ve_trx_sed = $sede;
            $vetrxlin->ve_bol_lho = date("H:i:s");
            $vetrxlin->ve_bol_ldi = $dias[date("w")];
            $vetrxlin->ve_bol_cve = $sic->SicVend;
            $vetrxlin->ve_trx_npo = $tseg02->Seg_NPos;
            $vetrxlin->ve_trx_pos = session()->get('Usu_usuario');
            $vetrxlin->ve_bol_cun = $linea->stock->Ex_art_cun;
            $vetrxlin->ve_bol_tco = $linea->SicArtCan+$linea->stock->Ex_art_cun;
            $vetrxlin->ve_bol_ob1 = 'COBRANZAS';
            $vetrxlin->save();

            $clicarto = new CLICARTO;
            $clicarto->Mb_Epr_cod = $this->Emp;
            $clicarto->Ve_Cod_Cli = $vetrxcab->Ve_Cod_Cli;
            $clicarto->Ve_doc_tip = $tipoDocto;
            $clicarto->Ve_pag_nro = $vetrxcab->ve_trx_no;
            $clicarto->Ve_pag_cuo = 0;
            $clicarto->Ve_pag_fem = $vetrxcab->Ve_bol_fec;
            $clicarto->Ve_pag_fve = $vetrxcab->ve_trx_fve; // aqui va la fecha de vencimiento real  modificar

            $vetrxcab->ve_trx_net = $vetrxcab->ve_trx_tli;
            $vetrxcab->ve_trx_iva  = round($vetrxcab->ve_trx_tli*($IVA/100),0);
            $vetrxcab->ve_trx_tot  = $vetrxcab->ve_trx_net + $vetrxcab->ve_trx_iva;
            $vetrxcab->update();
            $clicarto->Ve_pag_mon = $vetrxcab->ve_trx_net+$vetrxcab->ve_trx_iva;
            $clicarto->Ve_pag_sal = $vetrxcab->ve_trx_net+$vetrxcab->ve_trx_iva;
            $clicarto->Ve_pag_glo = 'VENTA A PARTIR DE SIC';
            $clicarto->Ve_pag_est = 1;
            $clicarto->Ve_pag_cob = $vetrxcab->Ve_bol_ven;
            $clicarto->Ve_pag_sed = $sede;
            $clicarto->Ve_pag_mod = 'PE';
            $clicarto->Ve_pag_cam = 1;
            $clicarto->Mb_Cod_Dep = $dpto;
            $clicarto->ve_pag_ven = $vetrxcab->Ve_bol_ven;
            $clicarto->save();
        }

        $emisor = EMPRES::first();
        $sedes = SEDES::where('Mb_Epr_cod', '=', $this->Emp)
                     ->where('Mb_Sedecod', '=', $sede)
                     ->first();
        
       
        if ($vetrxcab->Ve_tcod_pa > 9){
            $pago = 2;
        }else{
            $pago = 1;
        }
        
        dd($vetrxcab->ve_trx_tli);
        $xmlstr = '
        <Documento>
            <Encabezado>
                <IdDoc>
                    <TipoDTE>33</TipoDTE>
                    <Folio>'.$fac_nro.'</Folio>
                    <FchEmis>'.DateTime::createFromFormat('d/m/Y', $vetrxcab->Ve_bol_fec)->format('Y-m-d').'</FchEmis>
                    <FmaPago>'.$pago.'</FmaPago>
                    <FchVenc>'.DateTime::createFromFormat('d/m/Y', $vetrxcab->ve_trx_fve)->format('Y-m-d').'</FchVenc>
                </IdDoc>
                <Emisor>
                    <RUTEmisor>'.$emisor->Mb_Epr_rut.'-'.$emisor->Mb_Epr_dv.'</RUTEmisor>
                    <RznSoc>'.substr($emisor->Mb_Epr_raz,0,30).'</RznSoc>
                    <GiroEmis>'.substr($emisor->Mb_Epr_gir,0,60).'</GiroEmis>
                    <Acteco>'.$emisor->Mb_Cod_Ac1.'</Acteco>
        
                    <DirOrigen>'.$sedes->Mb_Sededir.'</DirOrigen>
                    <CmnaOrigen>'.$sedes->Mb_Sedeciu.'</CmnaOrigen>
                    <CiudadOrigen>'.$sedes->Mb_Sedeciu.'</CiudadOrigen>
                </Emisor>
                <Receptor>
                    <RUTRecep>'.$vetrxcab->Ve_Cod_Cli.'-'.$vetrxcab->cliente()->first()->Mb_Dv_aux.'</RUTRecep>
                    <CdgIntRecep>'.$vetrxcab->Ve_Cod_Cli.'-'.$vetrxcab->cliente()->first()->Mb_Dv_aux.'</CdgIntRecep>
                    <RznSocRecep>'.$vetrxcab->cliente()->first()->Mb_Razon_a.'</RznSocRecep>
                    <GiroRecep>'.substr($vetrxcab->cliente()->first()->giro()->first()->Mb_Des_gir,0,40).'</GiroRecep>
                    <DirRecep>'.$vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_dir_Aux.'</DirRecep>
                    <CmnaRecep>'.$vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_nom_ciu.'</CmnaRecep>
                    <CiudadRecep>'.$vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_nom_ciu.'</CiudadRecep>
                </Receptor>
                <Totales>
                    <MntNeto>'.strval($vetrxcab->ve_trx_net).'</MntNeto>
                    <TasaIVA>'.number_format(strval($vetrxcab->ve_trx_tiv),0,",",".").'%</TasaIVA>
                    <IVA>'.number_format(strval($vetrxcab->ve_trx_iva),0,",",".").'</IVA>
                    <MntTotal>'.number_format(strval($vetrxcab->ve_trx_tot),0,",",".").'</MntTotal>
                </Totales>
            </Encabezado>
        </Documento>';
       
        $xmlstr = $xmlstr.'';
        
       
        $dom = new DOMDocument();
        // Cargar el string XML
        $dom->loadXML($xmlstr);
        $sxe = simplexml_import_dom($dom);
        // Mostrar un valor
        dd($sxe);
        return redirect('recetarioMagistral/factura')->with('mensaje', 'SIC facturada con éxito');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
