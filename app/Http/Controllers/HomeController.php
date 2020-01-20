<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editais;
use App\Candidato;
use App\Candidaturas;
use Auth, DB, Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editais = Editais::all();
        $candidato = Candidato::where('user_id', Auth::user()->id)->first(); 
        $candidaturas = Candidaturas::where('candidato_id', Auth::user()->id)->get(); 

        $data = [
            'editais'      => $editais,
            'candidato'    => $candidato,
            'candidaturas' => $candidaturas
        ];
        
        return view('home')->with($data);
    }

    public function configuracoes()
    {
        return view('auth/passwords/reset');
    }
}
