<?php

namespace App\Http\Controllers;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->get('Rol_nombre')) {
             return redirect()->route('sic');
        }else{
           return view('seguridad.index');
        }
    }
}
