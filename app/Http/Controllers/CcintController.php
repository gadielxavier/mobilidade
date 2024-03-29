<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avaliacao_Ccint;
use App\Candidaturas;
use App\Comprovacao_Lattes;
use App\Comprovacao_Lattes_Arquivos;
use App\Editais;
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
        $avaliacoes = Avaliacao_Ccint::where('avaliador_id', Auth::user()->id)->where('finalizado', 0)->orderBy('id', 'desc')->get();

        $data = [
            'avaliacoes' => $avaliacoes
        ];

        //dd($avaliacoes);
        
        return view('ccint.ccint')->with($data);
    }

    public function avaliacoesFinalizadas()
    {
        $avaliacoes = Avaliacao_Ccint::where('avaliador_id', Auth::user()->id)->where('finalizado', 1)->orderBy('id', 'desc')->paginate(30);

        $data = [
            'avaliacoes' => $avaliacoes
        ];

        //dd($avaliacoes);
        
        return view('ccint.avaliacoesFinalizadas')->with($data);
    }


    public function details(Request $request, $id)
    {
        $candidatura = Candidaturas::find($id);
        $comprovacoes =  Comprovacao_Lattes::all(); 
        $arquivos = Comprovacao_Lattes_Arquivos::where('candidatura_id', $id)->get();
        $arquivoParticipacoes = [];
        $arquivoIndicadores = [];
        $arquivoRepresentacao = [];
        $arquivoInstitucional = [];

        foreach ($arquivos as $arquivo) {
            if($arquivo->comprovacao->tipo == 1){
                $arquivoParticipacoes[] = $arquivo;
            }
            else if($arquivo->comprovacao->tipo == 2){
                $arquivoIndicadores[] = $arquivo;
            }
            else if($arquivo->comprovacao->tipo == 3){
                $arquivoRepresentacao[] = $arquivo;
            }else{
                $arquivoInstitucional[] = $arquivo;
            }
        }

        $editalAeri = DB::table('programas')->where('id', 1)->first();

        $edital = Editais::where('id', $candidatura->edital_id)->first();

        $documentos = DB::table('documento_arquivo')
        ->where('documento_id', 1)
        ->where('candidatura_id', $candidatura->id)->get();

        $data = [
            'candidatura'          => $candidatura,
            'comprovacoes'         => $comprovacoes,
            'arquivoParticipacoes' => $arquivoParticipacoes,
            'arquivoIndicadores'   => $arquivoIndicadores,
            'arquivoRepresentacao' => $arquivoRepresentacao,
            'arquivoInstitucional' => $arquivoInstitucional,
            'editalAeri'           => $editalAeri,
            'edital'               => $edital,
            'documentos'           => $documentos
        ]; 
       
          return view('ccint.detalhes')->with($data);
    }

    protected function store(Request $request, $id)
    {

        $this->validate($request, [
            'estrutura'         => 'required|numeric|min:0|max:2',
            'objetividade'      => 'required|numeric|min:0|max:6',
            'clareza'           => 'required|numeric|min:0|max:2',
            'participacao.*'    => 'required|numeric|min:0|max:2',
            'indicadores.*'     => 'required|numeric|min:0|max:5',
            'representacao.*'   => 'required|numeric|min:0|max:1',
            'institucional.*'   => 'required|numeric|min:0|max:5',
            'ideias'            => 'required|numeric|min:0|max:5',
            'persistencia'      => 'required|numeric|min:0|max:5',
            'interesse'         => 'required|numeric|min:0|max:5',
            'problema'          => 'required|numeric|min:0|max:5',
            'criatividade'      => 'required|numeric|min:0|max:5',
            'escrita'           => 'required|numeric|min:0|max:5',
            'oral'              => 'required|numeric|min:0|max:5',
            'adicionais'        => 'required|numeric|min:0|max:2',
            'merito'            => 'required|numeric|min:0|max:3',
        ]);

        $avaliacao = Avaliacao_Ccint::where('candidatura_id', $id)->where('avaliador_id', Auth::user()->id)->first();

        $plano_trabalho = $request->estrutura + $request->objetividade + $request->clareza;

        $participacao = 0;

        if($request->participacao != null){
            foreach ($request->participacao as $valor) {
                $participacao += $valor;
            }
        }

        if($participacao > 10){
            $participacao = 10;
        }

         $indicadores = 0;

         if($request->indicadores != null){
            foreach ($request->indicadores as $valor) {
                $indicadores += $valor;
            }
        }

        if($indicadores > 10){
            $indicadores = 10;
        }

        $representacao = 0;

        if($request->representacao != null){
            foreach ($request->representacao as $valor) {
                $representacao += $valor;
            }
        }

        if($representacao > 10){
            $representacao = 10;
        }

        $institucional = 0;

        if($request->institucional != null){
            foreach ($request->institucional as $valor) {
                $institucional += $valor;
            }
        }

        if($institucional > 10){
            $institucional = 10;
        }

        $curriculum_lattes = $participacao +  $indicadores + $representacao + $institucional;

        $complemento = ($request->ideias + $request->persistencia + $request->interesse + $request->problema + $request->criatividade + $request->escrita + $request->oral) / 7;  

        $carta =  $complemento + $request->adicionais + $request->merito;

        $edital = Editais::where('id', $avaliacao->edital_id)->first();

        $maior_pontuacao = $edital->maior_pontuacao;

        if($curriculum_lattes > $maior_pontuacao){
            $maior_pontuacao = $curriculum_lattes;
        }

        try{
            $avaliacao->plano_trabalho = $plano_trabalho;
            $avaliacao->curriculum_lattes = $curriculum_lattes;
            $avaliacao->carta = $carta;
            $avaliacao->finalizado = true;
            $edital->maior_pontuacao = $maior_pontuacao;
            $avaliacao->save();
            $edital->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/ccint')->with('message', 'AVALIAÇÄO FINALIZADA COM SUCESSO!');;

    }

}
