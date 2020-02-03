<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionArticulo;
use App\Models\Articulos\ARTMAEST;
use Illuminate\Http\Request;

class ARTMAESTController extends Controller
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
        $articulos = ARTMAEST::where('Mb_Epr_cod', '=', $this->Emp)
                            ->where('Art_nom_ex', 'like', '%'.$filtro.'%')            
                            ->paginate(15);
        return view('articulos.index', compact('articulos', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('articulos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionArticulo $request)
    {
        $artmaest = new ARTMAEST;
        $artmaest->Mb_Epr_cod = $this->Emp;
        $artmaest->Art_cod = $request->Art_cod;
        $artmaest->Art_nom_ex = $request->Art_nom_ex;
        $artmaest->Art_serie = $request->Art_serie;
        $artmaest->ArtLote = $request->ArtLote;
        $artmaest->Art_fecElab = $request->Art_fecElab;
        $artmaest->Art_fecVenc = $request->Art_fecVenc;
        $artmaest->Art_horElab = $request->Art_horElab;
        $artmaest->Art_horVenc = $request->Art_horVenc;
        $artmaest->save();
        $notificacion = array(
            'mensaje' => 'Material creado con exitoo',
            'tipo' => 'success',
            'titulo' => 'Material'
        );
        return redirect('articulos')->with($notificacion);
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
    public function editar($Art_cod)
    {
        $articulo = ARTMAEST::where('Mb_Epr_cod', '=', $this->Emp)
                        ->where('Art_cod', '=', $Art_cod)
                        ->first();
        return view('articulos.editar', compact('articulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionArticulo $request, $Art_cod)
    {
        $artmaest = ARTMAEST::where('Mb_Epr_cod', '=', $this->Emp)
                ->where('Art_cod', 'like', '%'.$Art_cod.'%')
                ->first();
        $artmaest->Art_cod = $request->Art_cod;
        $artmaest->Art_nom_ex = $request->Art_nom_ex;
        $artmaest->Art_serie = $request->Art_serie;
        $artmaest->ArtLote = $request->ArtLote;
        $artmaest->Art_fecElab = $request->Art_fecElab;
        $artmaest->Art_fecVenc = $request->Art_fecVenc;
        $artmaest->Art_horElab = $request->Art_horElab;
        $artmaest->Art_horVenc = $request->Art_horVenc;
        $artmaest->update();

        $notificacion = array(
            'mensaje' => 'Material actualizado con éxito',
            'tipo' => 'success',
            'titulo' => 'Material'
        );
        return redirect('articulos')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Art_cod)
    {
        $artmaest = ARTMAEST::where('Mb_Epr_cod', '=', $this->Emp)
                            ->where('Art_cod', 'like', '%'.$Art_cod.'%')
                            ->first();
        if ($request->ajax()) {
            if ($artmaest->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
