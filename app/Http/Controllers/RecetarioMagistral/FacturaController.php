<?php

namespace App\Http\Controllers\RecetarioMagistral;

use App\Http\Controllers\Controller;
use App\Models\Cliente\CLIDEFIN;
use App\Models\DATA_SII\DTEEMITIDOS;
use App\Models\Estapas\GCETAPAS;
use App\Models\Factura\CLICARTO;
use App\Models\Factura\EMPRES;
use App\Models\Factura\SEDES;
use App\Models\Factura\VETRXCAB;
use App\Models\Factura\VETRXLIN;
use App\Models\Factura\VETRXPAR;
use App\Models\MovimientoInventario\EXISMOVC;
use App\Models\MovimientoInventario\EXISTKXL;
use App\Models\MovimientoInventario\EXISTOCK;
use App\Models\MovimientoInventario\EXISTRXC;
use App\Models\MovimientoInventario\EXISTRXL;
use App\Models\RecetarioMagistral\Receta;
use App\Models\Seguridad\TSEG02;
use App\Models\SIC\ADSICTRX;
use DateTime;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    private $Emp = 'INS';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filtro = $request->get('buscarpor');
        $sics = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
                        ->where('SicTip', '=', 2)
                        ->where(function($q) use ($filtro){
                            $q->where(strval('SicFol'), 'like', "%$filtro%")
                              ->orWhere(strval('SicPOnro'), 'like', "%$filtro%");
                        })
                        ->where('SicAut', '=', 'S')
                        ->whereIn('Proc_id', ['D','E'])
                        ->with('cliente', 'paciente', 'etapa')
                        ->with('lineasSIC', 'lineasSIC.articulo', 'lineasSIC.recetas')
                        ->get();
        return view('recetarioMagistral.factura.index', compact('sics', 'request'));
    }

    public function facturar($SicFol)
    {
        $sic = ADSICTRX::where('Mb_Epr_cod', '=', 'INS')
            ->where('SicTip', '=', 2)
            ->where('SicFol', '=', $SicFol)
            ->where('SicAut', '=', 'S')
            ->where('Proc_id', 'E')
            ->with('lineasSIC', 'lineasSIC.articulo', 'lineasSIC.stock', 'lineasSIC.recetas')
            ->with('cliente')
            ->with('clidefin')
            ->with('clidefin.formaPago')
            ->with('paciente')
            ->with('direccion')
            ->first();

        $recetas = array();
        foreach($sic->lineasSIC as $key => $linea){
            if(count($linea->recetas)>0){
                array_push($recetas, $key);
            }
        }
        if (count($recetas)>0) {
            $vetrxpar = VETRXPAR::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Mb_Sedecod', '=', 9999)
                ->where('gc_caja_co', '=', 99)
                ->first();
            $fac_nro = intval($vetrxpar->gc_fac_nro + 1); //FACTURA
            $vetrxpar->gc_fac_nro = $vetrxpar->gc_fac_nro + 1;
            $bol_nro = $vetrxpar->gc_bol_nro + 1; //NTRX
            $vetrxpar->gc_bol_nro = $vetrxpar->gc_bol_nro + 1;
            $vetrxpar->update();
            /* lo dejo en una variable por si cambia en el futuro */
            $IVA = 19;
            $sede = 1;
            $tipoDocto = 'FA';
            $dpto = 'V' . $sede;
            $tipcli = 'M';
            /* fin */

            $tseg02 = TSEG02::where('Seg_usuari', '=', session()->get('Usu_usuario'))
                ->with('cajero')
                ->first();

            $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
            $vetrxcab = new VETRXCAB();
            $vetrxcab->Mb_Epr_cod = $this->Emp;
            $vetrxcab->Ve_bol_nro = $bol_nro;
            $vetrxcab->Ve_bol_dep = $dpto;
            $vetrxcab->ve_bol_tip = $tipoDocto; //cambiar a parametro por tipo documento
            $vetrxcab->Ve_Cod_Cli = $sic->Ve_Cod_Cli;
            $vetrxcab->Ve_bol_ven = $sic->SicVend;
            $vetrxcab->Ve_bol_fec = date("d/m/Y"); // poner fecha contable mes abierto
            $vetrxcab->Ve_bol_nul = 'N';
            $vetrxcab->Ve_bol_ing = date("d/m/Y");
            $vetrxcab->Ve_bol_cog = 'N';
            $vetrxcab->Ve_bol_rem = 'N';
            $vetrxcab->ve_trx_sem = $dias[date("w")];
            $vetrxcab->Ve_bol_sed = $sede;
            $vetrxcab->Ve_bol_par = 1;
            $vetrxcab->Ve_bol_mon = 'PE';
            $vetrxcab->Ve_bol_exe = 'N';
            $vetrxcab->ve_trx_ob1 = 'FACTURA SIC Nº: ' . $sic->SicFol;
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
            $vetrxcab->ve_trx_noc = $sic->SicFol; //Folio de SIC se toma como Orden de Compra
            $vetrxcab->ve_trx_fve = date("d/m/Y", strtotime(date("d-m-Y") . "+ " . $sic->clidefin->formaPago->Ve_tds_pag . " days"));
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
            $vetrxlineas = array();

            $ve_bol_net = 0;
            $Ve_bol_tot = 0;
            $ve_trx_tli = 0;
            $Ve_bol_iva = 0;
            
            foreach ($recetas as $i => $receta) {
                
                $sic->lineasSIC[$i]->SicCanDesp = $sic->lineasSIC[$i]->recetas->sum('Rec_unidades');
                $sic->lineasSIC[$i]->update();

                $vetrxlin = new VETRXLIN;
                $vetrxlin->Mb_Epr_cod = $this->Emp;
                $vetrxlin->Ve_bol_nro = $bol_nro;
                $vetrxlin->Ve_bol_dep = $dpto;
                $vetrxlin->ve_bol_tip = $tipoDocto; //cambiar a parametro por tipo documento
                $vetrxlin->ve_bol_nli = $i + 1;
                $vetrxlin->Ve_bol_art = $sic->lineasSIC[$i]->Art_cod;
                $vetrxlin->ve_bol_cba = $sic->lineasSIC[$i]->Art_cod_la;
                $vetrxlin->ve_art_des = $sic->lineasSIC[$i]->articulo->Art_nom_ex;
                $vetrxlin->Ve_bol_bod = $sede;
                $vetrxlin->Ve_bol_ubi = 'EXI';
                $vetrxlin->Ve_bol_um = 'UN';
                $vetrxlin->Ve_bol_can = $sic->lineasSIC[$i]->SicCanDesp;
                $vetrxlin->ve_bol_pnu = $sic->lineasSIC[$i]->Sicartval;
                $vetrxlin->Ve_bol_pre = round($sic->lineasSIC[$i]->Sicartval * (1 + ($IVA / 100)));
                $vetrxlin->Ve_bol_lde = 0;
                $vetrxlin->ve_trx_prc = $sic->lineasSIC[$i]->Sicartval;
                $vetrxlin->ve_trx_sli = $sic->lineasSIC[$i]->SicArtCan * $sic->lineasSIC[$i]->Sicartval;
                $vetrxlin->Ve_bol_lto = $sic->lineasSIC[$i]->SicArtCan * round($sic->lineasSIC[$i]->Sicartval * (1 + ($IVA / 100)));
                $vetrxlin->ve_bol_cba = $sic->lineasSIC[$i]->Art_cod_la;
                $vetrxlin->ve_bol_fam = $sic->lineasSIC[$i]->Gc_fam_cod;
                $vetrxlin->ve_bol_fde = $sic->lineasSIC[$i]->Gc_fam_des;
                $vetrxlin->ve_bol_cla = $sic->lineasSIC[$i]->Gc_cla_cod;
                $vetrxlin->ve_bol_cde = $sic->lineasSIC[$i]->Gc_cla_des;
                $vetrxlin->ve_trx_fec = date("d/m/Y");
                $vetrxlin->ve_trx_sed = $sede;
                $vetrxlin->ve_bol_lho = date("H:i:s");
                $vetrxlin->ve_bol_ldi = $dias[date("w")];
                $vetrxlin->ve_bol_cve = $sic->SicVend;
                $vetrxlin->ve_trx_npo = $tseg02->Seg_NPos;
                $vetrxlin->ve_trx_pos = session()->get('Usu_usuario');
                $vetrxlin->ve_bol_cun = $sic->lineasSIC[$i]->stock->Ex_art_cun;
                $vetrxlin->ve_bol_tco = $sic->lineasSIC[$i]->SicArtCan + $sic->lineasSIC[$i]->stock->Ex_art_cun;
                $vetrxlin->ve_bol_ob1 = 'COBRANZAS';
                $vetrxlin->save();

                $sic->lineasSIC[$i]->SicDocDesp = $tipoDocto;
                $sic->lineasSIC[$i]->SicNumDoc = $fac_nro;
                $sic->lineasSIC[$i]->SicFecDesp = date("d/m/Y");
                $sic->lineasSIC[$i]->update();

                array_push($vetrxlineas, $vetrxlin);
                $Ve_bol_tot += $vetrxlin->Ve_bol_lto;
                $ve_trx_tli += $vetrxlin->ve_trx_sli;
            }
            
            $ve_bol_net = round($Ve_bol_tot / (1 + $IVA / 100), 0);
            //$Ve_bol_iva = ($Ve_bol_tot-$ve_bol_net)*$factor;

            $clicarto = new CLICARTO;
            $clicarto->Mb_Epr_cod = $this->Emp;
            $clicarto->Ve_Cod_Cli = $vetrxcab->Ve_Cod_Cli;
            $clicarto->Ve_doc_tip = $tipoDocto;
            $clicarto->Ve_pag_nro = $vetrxcab->ve_trx_no;
            $clicarto->Ve_pag_cuo = 0;
            $clicarto->Ve_pag_fem = $vetrxcab->Ve_bol_fec;
            $clicarto->Ve_pag_fve = $vetrxcab->ve_trx_fve; // aqui va la fecha de vencimiento real  modificar

            $vetrxcab->ve_trx_net = $ve_trx_tli;
            $vetrxcab->ve_trx_iva = round($ve_trx_tli * ($IVA / 100), 0);
            $vetrxcab->ve_trx_tot = $vetrxcab->ve_trx_net + $vetrxcab->ve_trx_iva;
            $vetrxcab->update();

            $clicarto->Ve_pag_mon = $vetrxcab->ve_trx_net + $vetrxcab->ve_trx_iva;
            $clicarto->Ve_pag_sal = $vetrxcab->ve_trx_net + $vetrxcab->ve_trx_iva;
            $clicarto->Ve_pag_glo = 'VENTA A PARTIR DE SIC';
            $clicarto->Ve_pag_est = 1;
            $clicarto->Ve_pag_cob = $vetrxcab->Ve_bol_ven;
            $clicarto->Ve_pag_sed = $sede;
            $clicarto->Ve_pag_mod = 'PE';
            $clicarto->Ve_pag_cam = 1;
            $clicarto->Mb_Cod_Dep = $dpto;
            $clicarto->ve_pag_ven = $vetrxcab->Ve_bol_ven;
            $clicarto->save();

            $emisor = EMPRES::first();
            $sedes = SEDES::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Mb_Sedecod', '=', $sede)
                ->first();

            if ($vetrxcab->Ve_tcod_pa > 9) {
                $pago = 2;
            } else {
                $pago = 1;
            }
            $Mb_reg_cli = $vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_reg_cli;
            $Mb_Ciu_Aux = $vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_Ciu_Aux;
            //dd($vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->region($Mb_reg_cli, $Mb_Ciu_Aux)->Mb_nom_ciu);
            $xmlstr = '<?xml version="1.0" encoding="UTF-8"?>
            <Documento>
            <Encabezado>
                <IdDoc>
                    <TipoDTE>33</TipoDTE>
                    <Folio>' . $fac_nro . '</Folio>
                    <FchEmis>' . DateTime::createFromFormat('d/m/Y', $vetrxcab->Ve_bol_fec)->format('Y-m-d') . '</FchEmis>
                    <FmaPago>' . $pago . '</FmaPago>
                    <FchVenc>' . DateTime::createFromFormat('d/m/Y', $vetrxcab->ve_trx_fve)->format('Y-m-d') . '</FchVenc>
                </IdDoc>
                <Emisor>
                    <RUTEmisor>' . $emisor->Mb_Epr_rut . '-' . $emisor->Mb_Epr_dv . '</RUTEmisor>
                    <RznSoc>' . substr($emisor->Mb_Epr_raz, 0, 30) . '</RznSoc>
                    <GiroEmis>' . substr($emisor->Mb_Epr_gir, 0, 60) . '</GiroEmis>
                    <Acteco>' . $emisor->Mb_Cod_Ac1 . '</Acteco>

                    <DirOrigen>' . $sedes->Mb_Sededir . '</DirOrigen>
                    <CmnaOrigen>' . $sedes->Mb_Sedeciu . '</CmnaOrigen>
                    <CiudadOrigen>' . $sedes->Mb_Sedeciu . '</CiudadOrigen>
                </Emisor>
                <Receptor>
                    <RUTRecep>' . $vetrxcab->Ve_Cod_Cli . '-' . $vetrxcab->cliente()->first()->Mb_Dv_aux . '</RUTRecep>
                    <CdgIntRecep>' . $vetrxcab->Ve_Cod_Cli . '-' . $vetrxcab->cliente()->first()->Mb_Dv_aux . '</CdgIntRecep>
                    <RznSocRecep>' . $vetrxcab->cliente()->first()->Mb_Razon_a . '</RznSocRecep>
                    <GiroRecep>' . substr($vetrxcab->cliente()->first()->giro()->first()->Mb_Des_gir, 0, 40) . '</GiroRecep>
                    <DirRecep>' . $vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->Mb_dir_Aux . '</DirRecep>
                    <CmnaRecep>' . $vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->region($Mb_reg_cli, $Mb_Ciu_Aux)->Mb_nom_ciu . '</CmnaRecep>
                    <CiudadRecep>' . $vetrxcab->direccion($vetrxcab->Ve_Cod_Cli, $vetrxcab->ve_trx_dfa)->region($Mb_reg_cli, $Mb_Ciu_Aux)->Mb_nom_ciu . '</CiudadRecep>
                </Receptor>
                <Totales>
                    <MntNeto>' . round($vetrxcab->ve_trx_net, 0) . '</MntNeto>
                    <TasaIVA>' . round($vetrxcab->ve_trx_tiv, 0) . '</TasaIVA>
                    <IVA>' . round($vetrxcab->ve_trx_iva, 0) . '</IVA>
                    <MntTotal>' . round($vetrxcab->ve_trx_tot, 0) . '</MntTotal>
                </Totales>
            </Encabezado>';

            foreach ($vetrxlineas as $key => $vetrxlinea) {
                $xmlstr = $xmlstr . '<Detalle>
                <NroLinDet>' . ($key + 1) . '</NroLinDet>
                <CdgItem>
                    <TpoCodigo>INTERNO</TpoCodigo>
                    <VlrCodigo>' . $vetrxlinea->Ve_bol_art . '</VlrCodigo>
                </CdgItem>
                <NmbItem>' . trim($vetrxlinea->ve_art_des) . '</NmbItem>';
                if (trim($vetrxlinea->ve_trx_nlo) && trim($vetrxlinea->ve_trx_nlo) != 'S/N') {
                    $xmlstr = $xmlstr . '
                    <DscItem>' . trim(strtoupper($vetrxlinea->ve_trx_nlo)) . '</DscItem>';
                    if ($vetrxlinea->ve_lot_fve) {
                        $xmlstr = $xmlstr . '
                        <FchVencim>' . DateTime::createFromFormat('d/m/Y', $vetrxcab->Ve_bol_fec)->format('Y-m-d') . '</FchVencim>';
                    }
                }
                $xmlstr = $xmlstr . '
                <QtyItem>' . number_format(strval($vetrxlinea->Ve_bol_can), 0, ",", ".") . '</QtyItem>
                <PrcItem>' . number_format(strval($vetrxlinea->ve_bol_pnu), 0, ",", ".") . '</PrcItem>
                <MontoItem>' . $vetrxlinea->ve_trx_sli . '</MontoItem>
            </Detalle>';
            }

            if ($vetrxcab->ve_trx_noc) {
                $xmlstr = $xmlstr .
                '<Referencia>
                <NroLinRef>1</NroLinRef>
                <TpoDocRef>801</TpoDocRef>
                <FolioRef>' . $vetrxcab->ve_trx_noc . '</FolioRef>
                <FchRef>' . DateTime::createFromFormat('d/m/Y', $vetrxcab->Ve_bol_fec)->format('Y-m-d') . '</FchRef>
                <CodRef>3</CodRef>
                <RazonRef>ORDEN DE COMPRA</RazonRef>
        </Referencia>';
            }

            $xmlstr = $xmlstr .
            '<Adjuntos>

                <Observacion>' . 'FORMA PAGO : ' . trim($vetrxcab->ve_trx_fpa) . ' / ' . trim($vetrxcab->ve_trx_ob1) . '</Observacion>
                <Impresora>' . 'FILE://' . session()->get('Usu_usuario') . '/' . $tipoDocto . $fac_nro . '</Impresora>
                <Copias>0</Copias>
                <Doble>false</Doble>
                <Preimpreso>treu</Preimpreso>
                <TipoImp>\\venus\dtestorage.cl\EMISORES\INSUVAL\ENTRADA\</TipoImp>
                <Vendedor>' . substr($vetrxcab->Ve_bol_ven, 0, 15) . '</Vendedor>
                <Hora>' . date("H:i:s") . '</Hora>
        </Adjuntos></Documento>';

            $textoXML = mb_convert_encoding($xmlstr, "UTF-8");

            $slash = '\\';
            $gestor = fopen($slash . "\\venus\dtestorage.cl\EMISORES\INSUVAL\ENTRADA" . $slash . $tipoDocto . $fac_nro . ".xml", 'w');
            fwrite($gestor, $textoXML);
            fclose($gestor);
            //  DB::listen(function ($query) {
            //      if (strpos($query->sql, 'dte')!=false)
            //      {
            //         echo "<pre>". print_r($query->sql,1). "</pre>";
            //         echo "<pre>". print_r($query->bindings,1). "</pre>";
            //      }
            //  });
            $dteemitidos = null;
            for ($i = 1; $i < 5; $i++) {
                $dteemitidos = DTEEMITIDOS::select('dteHash')->where('emisorRut', '=', 77768990)
                    ->where('dteTipo', '=', 33)
                    ->where('dteFolio', '=', $fac_nro)
                    ->first();
                if ($dteemitidos == null) {
                    sleep(1);
                } else {
                    break;
                }
            }
            if ($dteemitidos == null) {
                $notificacion = array(
                    'mensaje' => 'No se pudo facturar, contácte al administrador de facturación electrónica',
                    'tipo' => 'info',
                    'titulo' => 'Factura',
                );
                return redirect('recetarioMagistral/factura')->with($notificacion);
            }
            $this->D1($SicFol);
            return redirect('http://pruebas.dtestorage.cl/Documento/EmitidoDescarga/' . trim($dteemitidos->dteHash));
        } else {
            $notificacion = array(
                'mensaje' => 'No se pudo facturar, no hay recetas preparadas',
                'tipo' => 'info',
                'titulo' => 'Factura',
            );
    
            return redirect('recetarioMagistral/factura')->with($notificacion);
        }

    }

    public function D1($SicFol){
        $sic = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
                       ->where('SicTip', '=', 2)
                       ->where('SicFol', '=', $SicFol)
                       ->first();
        $registrosI15 = array();
        $existrxc = EXISTRXC::where('Mb_Epr_cod', '=', $this->Emp)
                                ->where('ex_num_ord', '=', $sic->SicFol)
                                ->where('ex_num_oc', '=', $sic->SicPOnro)
                                ->where('ex_cod_aux', '=', $sic->Ve_Cod_Cli)
                                ->where('Ex_mov_cod', '=', 'I15')
                                ->first();
        array_push($registrosI15, $existrxc);

        $existrxl = EXISTRXL::where('MOV_FOLIO', '=', $registrosI15[0]->MOV_FOLIO)
                                ->where('Ex_mov_cod', '=', $registrosI15[0]->Ex_mov_cod)
                                ->first();
        array_push($registrosI15, $existrxl);
        $registrosD1 = $this->Pex002($registrosI15);

        $this->actualizarLote($registrosD1);
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

    private function Pex002($registrosI15)
    { //Movimiento D1, y creción y Movimiento Lote (Rec_codigo)

        $cod_mov = 'D1';
        $EX_OBS1 = 'Facturacion PT';
        $Mov_serie = $this->obtenerFolio($cod_mov);

        $existrxc = new EXISTRXC;
        $existrxc->MOV_FOLIO = $Mov_serie;
        $existrxc->Ex_mov_cod = $cod_mov;
        $existrxc->Mb_Epr_cod = $this->Emp;
        $existrxc->MOV_FECHA = $registrosI15[0]->MOV_FECHA;
        $existrxc->MOV_HORA = date("H:i:s");
        $existrxc->EX_ESTDOC = 'D';
        $existrxc->EX_ESTPRT = 'N';
        $existrxc->MOV_STATUS = 'A';
        $existrxc->Mb_Tip_Doc = $registrosI15[0]->Mb_Tip_Doc;
        $existrxc->EX_NRODOCT = $registrosI15[0]->EX_NRODOCT;
        $existrxc->EX_OBS1 = $EX_OBS1;
        $existrxc->EX_OBS2 = $EX_OBS1;
        $existrxc->EX_INDANUL = 'N';
        $existrxc->Mov_gd_fol = $registrosI15[0]->Mov_gd_fol;
        $existrxc->EX_SEDE = $registrosI15[0]->exisbode()->first()->Bod_sede;
        $existrxc->EX_BODSEDE = $registrosI15[0]->Bod_destin;
        $existrxc->Bod_destin = $registrosI15[0]->EX_BODSEDE;
        $existrxc->ex_trx_cos = 'S';
        $existrxc->Ex_recde = session()->get('Usu_usuario');
        $existrxc->save();

        $existrxl = new EXISTRXL;
        $existrxl->MOV_FOLIO = $Mov_serie;
        $existrxl->Ex_mov_cod = $cod_mov;
        $existrxl->Mb_Epr_cod = $this->Emp;
        $existrxl->EX_LINEA = 1;
        $existrxl->Art_cod = $registrosI15[1]->Art_cod;
        $existrxl->MOV_ART_CA = $registrosI15[1]->MOV_ART_CA;
        $existrxl->MOV_ART_VA = $registrosI15[1]->MOV_ART_VA;
        $existrxl->MOV_ART_UM = 'UN';
        $existrxl->mov_art_tc = ($registrosI15[1]->MOV_ART_CA * $registrosI15[1]->MOV_ART_VA);
        $existrxl->BOD_EXIS   = $registrosI15[0]->Bod_destin;
        $existrxl->Mov_ubi_co = 'EXI';
        $existrxl->Ex_art_bar = $registrosI15[1]->mov_art_cb;
        $existrxl->art_lote   = $registrosI15[1]->art_lote;
        $existrxl->Art_Fec_Vc = date('d-m-Y', strtotime($registrosI15[1]->Art_Fec_Vc));
        $existrxl->save();

        return array($existrxc, $existrxl);
    }

    private function actualizarLote($registrosD1)
    { //Actualiza stock lote (Rec_codigo)
        $existock = EXISTOCK::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ex_art_cod', '=', $registrosD1[1]->Art_cod)
            ->where('Ex_bod_cod', '=', $registrosD1[1]->BOD_EXIS)
            ->where('Ex_ubi_cod', '=', $registrosD1[1]->Mov_ubi_co)
            ->first();
        if ($existock) {
            $existock->Ex_art_cau = $registrosD1[1]->Ex_mov_cod;
            $existock->Ex_art_trx = $registrosD1[1]->MOV_FOLIO;
            $existock->Ex_art_Ftr = date("d/m/Y");
            $existock->Ex_art_hor = date("H:i:s");
            $existock->Stock_actu = $existock->Stock_actu - $registrosD1[1]->MOV_ART_CA;
            if ($registrosD1[1]->articulo()->first()->Art_ind_se == 'S') { //Rebaja Lote
                $existkxl = EXISTKXL::where('Mb_Epr_cod', '=', $this->Emp)
                    ->where('Ex_bod_cod', '=', $registrosD1[1]->BOD_EXIS)
                    ->where('Ex_art_cod', '=', $registrosD1[1]->Art_cod)
                    ->where('Ex_nro_lot', '=', $registrosD1[1]->art_lote)
                    ->where('Ex_prv_cod', '=', 99)
                    ->first();
                if ($existkxl) {
                    $existkxl->Ex_lot_cst = $registrosD1[1]->MOV_ART_VA;
                    $existkxl->Ex_lot_fec = $registrosD1[1]->Art_Fec_Vc;
                    $existkxl->Ex_lot_can = $existkxl->Ex_lot_can - $registrosD1[1]->MOV_ART_CA;
                    $existkxl->update();
                } else {
                    $existkxl = new EXISTKXL;
                    $existkxl->Mb_Epr_cod = $this->Emp;
                    $existkxl->Ex_bod_cod = $registrosD1[1]->BOD_EXIS;
                    $existkxl->Ex_art_cod = $registrosD1[1]->Art_cod;
                    $existkxl->Ex_nro_lot = $registrosD1[1]->art_lote;
                    $existkxl->Ex_prv_cod = 99;
                    $existkxl->Ex_lot_cst = $registrosD1[1]->MOV_ART_VA;
                    $existkxl->Ex_lot_fec = $registrosD1[1]->Art_Fec_Vc;
                    $existkxl->Ex_lot_can = $registrosD1[1]->MOV_ART_CA * -1;
                    $existkxl->save();
                }
            }
            $existock->update();
        } else {
            $existock = new EXISTOCK;
            $existock->Mb_Epr_cod = $this->Emp;
            $existock->Ex_art_cod = $registrosD1[1]->Art_cod;
            $existock->Ex_bod_cod = $registrosD1[1]->BOD_EXIS;
            $existock->Ex_ubi_cod = $registrosD1[1]->Mov_ubi_co;
            $existock->Ex_art_Ftr = date("d/m/Y");
            $existock->Ex_art_hor = date("H:i:s");
            $existock->Ex_art_cau = $registrosD1[1]->Ex_mov_cod;
            $existock->Ex_art_trx = $registrosD1[1]->MOV_FOLIO;
            $existock->Stock_actu = $registrosD1[1]->MOV_ART_CA * -1;

            $existock->save();
        }
        $registrosD1[0]->EX_ESTDOC = 'C';
        $registrosD1[0]->update();
    }

    public function gdespacho($SicFol){
        $sic = ADSICTRX::where('Mb_Epr_cod', '=', 'INS')
            ->where('SicTip', '=', 2)
            ->where('SicFol', '=', $SicFol)
            ->where('SicAut', '=', 'S')
            ->whereIn('Proc_id', ['C', 'D'])
            ->with('lineasSIC', 'lineasSIC.articulo', 'lineasSIC.stock', 'lineasSIC.recetas')
            ->with('cliente')
            ->with('clidefin')
            ->with('clidefin.formaPago')
            ->with('paciente')
            ->with('direccion')
            ->first();

        $recetas = array();
        foreach($sic->lineasSIC as $key => $linea){
            if(count($linea->recetas)>0){
                array_push($recetas, $key);
            }
        }
        if (count($recetas)>0) {
        }else {
            $notificacion = array(
                'mensaje' => 'No se pudo facturar, no hay recetas preparadas',
                'tipo' => 'info',
                'titulo' => 'Factura',
            );
    
            return redirect('recetarioMagistral/factura')->with($notificacion);
        }
    }

    public function dte($dteemitidos, $fac_nro)
    {
        $dteemitidos = DTEEMITIDOS::select('dteHash')->where('emisorRut', '=', 77768990)
            ->where('dteTipo', '=', 33)
            ->where('dteFolio', '=', $fac_nro)
            ->first();
        if (!$dteemitidos) {
            $this->dte($dteemitidos, $fac_nro);
        }
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
