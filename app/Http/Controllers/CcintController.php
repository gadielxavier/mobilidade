<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avaliacao_Ccint;
use App\Candidaturas;
use App\Comprovacao_Lattes;
use App\Comprovacao_Lattes_Arquivos;
use Auth, DB, Log;

class CcintController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avaliacoes = Avaliacao_Ccint::where('avaliador_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        $data = [
            'avaliacoes' => $avaliacoes
        ];
        
        return view('ccint.ccint')->with($data);
    }


    public function details(Request $request, $id)
    {
        $candidatura = Candidaturas::find($id);
        $comprovacoes =  Comprovacao_Lattes::all(); 
        $arquivos = Comprovacao_Lattes_Arquivos::where('candidatura_id', $id)->get();

        $data = [
            'candidatura' => $candidatura,
            'comprovacoes' => $comprovacoes,
            'arquivos' => $arquivos
        ]; 
       
          return view('ccint.detalhes')->with($data);
    }

}
