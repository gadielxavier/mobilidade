<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Editais;
use App\Candidato;
use App\Candidaturas;
use App\Recursos;
use App\Resposta_Recurso;
use App\Status_Inscricao;
use App\Comprovacao_Lattes;
use App\Comprovacao_Lattes_Arquivos;
use App\Avaliacao_Ccint;
use Redirect;
use Auth, DB, Log;

class CandidaturasController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editais = Editais::all();
        $candidato = Candidato::where('user_id', Auth::user()->id)->first(); 
        
        if($candidato == null){
             $candidaturas = null;

        } 
        else{
            $candidaturas = Candidaturas::where('candidato_id', $candidato->id)->get();
        } 

        $data = [
            'editais'      => $editais,
            'candidato'    => $candidato,
            'candidaturas' => $candidaturas
        ];
        
        return view('candidaturas.candidaturas')->with($data);
    }

    public function inscricao(Request $request, $id)
    {

        $edital = Editais::find($id);
        $comprovacoes =  Comprovacao_Lattes::all();

        $data = [
            'edital' => $edital,
            'comprovacoes' => $comprovacoes
        ]; 
        
        return view('candidaturas.inscricao')->with($data);
    }

    public function atualizacao(Request $request, $id)
    {

       $candidato = Candidato::where('user_id', Auth::user()->id)->first();

       $candidatura =  Candidaturas::where('candidato_id', $candidato->id)->where('edital_id', $id)->first();
       $comprovacoes =  Comprovacao_Lattes::all();
       $arquivos = Comprovacao_Lattes_Arquivos::where('candidatura_id', $candidatura->id)->get();

        $data = [
            'candidatura' => $candidatura,
            'arquivos' => $arquivos,
            'comprovacoes' => $comprovacoes
        ]; 
       
        return view('candidaturas.atualizacao')->with($data);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'matricula' => 'file|max:8000',
            'historico' => 'file|max:8000',
            'percentual' => 'file|max:8000',
            'curriculum' => 'file|max:8000',
            'trabalho1' => 'file|max:8000',
            'trabalho2' => 'file|max:8000',
            'trabalho3' => 'file|max:8000',
            'estudo1' => 'file|max:8000',
            'estudo2' => 'file|max:8000',
            'estudo3' => 'file|max:8000',
        ]);

        $candidaturas = Candidaturas::find($id);

        $edital = Editais::where('id', $candidaturas->edital_id)->first();


        if ($request->hasFile('matricula') && $request->file('matricula')->isValid()){
            $matricula = $request->file('matricula')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'matricula');
        }else{
             $matricula =  $candidaturas->matricula;
        }


        if ($request->hasFile('historico') && $request->file('historico')->isValid()){
            $historico = $request->file('historico')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'historico');
        }else{
             $historico =  $candidaturas->historico;
        }

        if ($request->hasFile('percentual') && $request->file('percentual')->isValid()){
            $percentual = $request->file('percentual')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'percentual');
        }else{
             $percentual =  $candidaturas->percentual;
        }

        if ($request->hasFile('curriculum') && $request->file('curriculum')->isValid()){
            $curriculum = $request->file('curriculum')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'curriculum');
        }else{
             $curriculum =  $candidaturas->curriculum;
        }

        if ($request->hasFile('trabalho1') && $request->file('trabalho1')->isValid()){
            $trabalho1 = $request->file('trabalho1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho1');
        }else{
             $trabalho1 =  $candidaturas->plano_trabalho1;
        }

        if ($request->hasFile('trabalho2') && $request->file('trabalho2')->isValid()){
            $trabalho2 = $request->file('trabalho2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho2');
        }else{
             $trabalho2 =  $candidaturas->plano_trabalho2;
        }

        if ($request->hasFile('trabalho3') && $request->file('trabalho3')->isValid()){
            $trabalho3 = $request->file('trabalho3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho3');
        }else{
             $trabalho3 =  $candidaturas->plano_trabalho3;
        }

        if ($request->hasFile('estudo1') && $request->file('estudo1')->isValid()){
            $estudo1 = $request->file('estudo1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo1');
        }else{
             $estudo1 =  $candidaturas->plano_estudo1;
        }

        if ($request->hasFile('estudo2') && $request->file('estudo2')->isValid()){
            $estudo2 = $request->file('estudo2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo2');
        }else{
             $estudo2 =  $candidaturas->plano_estudo2;
        }

        if ($request->hasFile('estudo3') && $request->file('estudo3')->isValid()){
            $estudo3 = $request->file('estudo3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo3');
        }else{
             $estudo3 =  $candidaturas->plano_estudo3;
        }

        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()){
            $certificado = $request->file('certificado')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado');
        }else{
             $certificado =  $candidaturas->certificado;
        }


        try{
            $candidaturas->primeira_opcao_universidade = $request->opcao1universidade;
            $candidaturas->primeira_opcao_curso = $request->opcao1curso;
            $candidaturas->primeira_opcao_pais = $request->opcao1pais;
            $candidaturas->segunda_opcao_universidade = $request->opcao2universidade;
            $candidaturas->segunda_opcao_curso = $request->opcao2curso;
            $candidaturas->segunda_opcao_pais = $request->opcao2pais;
            $candidaturas->terceira_opcao_universidade = $request->opcao3universidade;
            $candidaturas->terceira_opcao_curso = $request->opcao3curso;
            $candidaturas->terceira_opcao_pais = $request->opcao3pais;
            $candidaturas->matricula = $matricula;
            $candidaturas->historico = $historico;
            $candidaturas->percentual = $percentual;
            $candidaturas->curriculum = $curriculum;
            $candidaturas->plano_trabalho1 = $trabalho1;
            $candidaturas->plano_trabalho2 = $trabalho2;
            $candidaturas->plano_trabalho3 = $trabalho3;
            $candidaturas->plano_estudo1 = $estudo1;
            $candidaturas->plano_estudo2 = $estudo2;
            $candidaturas->plano_estudo3 = $estudo3;
            $candidaturas->certificado = $certificado;
            $candidaturas->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        $comprovacao = $request->comprovacao;
        $categoria = $request->categoria;


        for($count = 0; $count < count($comprovacao); $count++)
        {

            if ($request->hasFile('comprovacao.' . $count) && $request->file('comprovacao.' . $count)->isValid()){

                $arquivo = $request->file('comprovacao.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                DB::beginTransaction();
                    try{
                        $comprovacao_arquivo = Comprovacao_Lattes_Arquivos::create([
                        'candidatura_id' => $id,
                        'arquivo' => $arquivo,
                        'comprovacao_lattes_id' => $request->categoria[$count]
                    ]);
                        
                        DB::commit();
                    }
                     catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e);
                        return $this->error($e->getMessage(), 500, $e);
                    }
            }
        }

        return redirect('/home');
    }

    public function details(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();
        $recursos = Recursos::where('candidato_id', $candidatura->candidato->id)->where('edital_id', $candidatura->edital->id)->get();
        $avaliacao = Avaliacao_Ccint::where('candidatura_id', $candidatura->id)->first();
        $edital = Editais::where('id', $candidatura->edital_id)->first();

        

        $data = [
            'candidatura' => $candidatura,
            'recursos'     => $recursos,
            'avaliacao'   => $avaliacao,
            'edital'      => $edital
        ]; 
       
          return view('candidaturas.detalhes')->with($data);
    }

    /**
     * Store a new edital.
     *
     * @param  Request  $request
     * @return Response
     */
    protected function store(Request $request, $id)
    {

        $edital = Editais::where('id', $id)->first();

        $this->validate($request, [
            'matricula' => 'required|file|max:8000',
            'historico' => 'required|file|max:8000',
            'percentual' => 'required|file|max:8000',
            'curriculum' => 'required|file|max:8000',
            'trabalho1' => 'required|file|max:8000',
            'trabalho2' => 'required|file|max:8000',
            'trabalho3' => 'required|file|max:8000',
            'estudo1' => 'required|file|max:8000',
            'estudo2' => 'required|file|max:8000',
            'estudo3' => 'required|file|max:8000',
        ]);
  

        if ($request->hasFile('matricula') && $request->file('matricula')->isValid()){
            $matricula = $request->file('matricula')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'matricula');
        }else{
             $matricula = 0;
        }

        if ($request->hasFile('historico') && $request->file('historico')->isValid()){
            $historico = $request->file('historico')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'historico');
        }else{
             $historico = 0;
        }

        if ($request->hasFile('percentual') && $request->file('percentual')->isValid()){
            $percentual = $request->file('percentual')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'percentual');
        }else{
             $percentual = 0;
        }

        if ($request->hasFile('curriculum') && $request->file('curriculum')->isValid()){
            $curriculum = $request->file('curriculum')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'curriculum');
        }else{
             $curriculum = 0;
        }

        if ($request->hasFile('trabalho1') && $request->file('trabalho1')->isValid()){
            $trabalho1 = $request->file('trabalho1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho1');
        }else{
             $trabalho1 = 0;
        }

        if ($request->hasFile('trabalho2') && $request->file('trabalho2')->isValid()){
            $trabalho2 = $request->file('trabalho2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho2');
        }else{
             $trabalho2 = 0;
        }

        if ($request->hasFile('trabalho3') && $request->file('trabalho3')->isValid()){
            $trabalho3 = $request->file('trabalho3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho3');
        }else{
             $trabalho3 = 0;
        }

        if ($request->hasFile('estudo1') && $request->file('estudo1')->isValid()){
            $estudo1 = $request->file('estudo1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo1');
        }else{
             $estudo1 = 0;
        }

        if ($request->hasFile('estudo2') && $request->file('estudo2')->isValid()){
            $estudo2 = $request->file('estudo2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo2');
        }else{
             $estudo2 = 0;
        }

        if ($request->hasFile('estudo3') && $request->file('estudo3')->isValid()){
            $estudo3 = $request->file('estudo3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo3');
        }else{
             $estudo3 = 0;
        }

        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()){
            $certificado = $request->file('certificado')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado');
        }else{
             $certificado = 0;
        }
        if ($request->hasFile('carta') && $request->file('carta')->isValid()){
            $carta = $request->file('carta')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'carta');
        }else{
             $carta = 0;
        }

        $candidato = Candidato::where('user_id', Auth::user()->id)->first();



        DB::beginTransaction();
        try{
            $candidatura = Candidaturas::create([
            'candidato_id' => $candidato->id,
            'edital_id' => $id,
            'primeira_opcao_universidade'=> $request->opcao1universidade,
            'primeira_opcao_curso' => $request->opcao1curso,
            'primeira_opcao_pais' => $request->opcao1pais,
            'segunda_opcao_universidade' => $request->opcao2universidade,
            'segunda_opcao_curso' => $request->opcao2curso,
            'segunda_opcao_pais'=> $request->opcao2pais,
            'terceira_opcao_universidade'=> $request->opcao3universidade,
            'terceira_opcao_curso'=> $request->opcao3curso,
            'terceira_opcao_pais'=> $request->opcao3pais,
            'matricula'=> $matricula,
            'historico'=> $historico,
            'percentual'=> $percentual,
            'curriculum'=> $curriculum,
            'plano_trabalho1'=> $trabalho1,
            'plano_trabalho2'=> $trabalho2,
            'plano_trabalho3'=> $trabalho3,
            'plano_estudo1'=> $estudo1,
            'plano_estudo2'=> $estudo2,
            'plano_estudo3'=> $estudo3,
            'certificado'=> $certificado,
            'status_id'=> 1,
            'carta'=> $carta
        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        $comprovacao = $request->comprovacao;
        $categoria = $request->categoria;


        for($count = 0; $count < count($comprovacao); $count++)
        {

            if ($request->hasFile('comprovacao.' . $count) && $request->file('comprovacao.' . $count)->isValid()){

                $arquivo = $request->file('comprovacao.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                DB::beginTransaction();
                    try{
                        $comprovacao_arquivo = Comprovacao_Lattes_Arquivos::create([
                        'candidatura_id' => $candidatura->id,
                        'arquivo' => $arquivo,
                        'comprovacao_lattes_id' => $request->categoria[$count]
                    ]);
                        
                        DB::commit();
                    }
                     catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e);
                        return $this->error($e->getMessage(), 500, $e);
                    }
            }
        }

        return redirect('/candidaturas');

    }

    public function deleteComprovante($id)
    {
        $comprovacao = Comprovacao_Lattes_Arquivos::find($id);
        $comprovacao->delete();
        return Redirect::back();
    }

    public function matricula(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->matricula;

        return response()->file($path); 
    }

    public function historico(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->historico;

        return response()->file($path); 
    }

    public function percentual(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->percentual;

        return response()->file($path); 
    }

    public function curriculum(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->curriculum;

        return response()->file($path); 
    }

    public function trabalho1(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_trabalho1;

        return response()->file($path); 
    }

    public function trabalho2(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_trabalho2;

        return response()->file($path); 
    }

    public function trabalho3(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_trabalho3;

        return response()->file($path); 
    }

    public function estudo1(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_estudo1;

        return response()->file($path); 
    }

    public function estudo2(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_estudo2;

        return response()->file($path); 
    }

    public function estudo3(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_estudo3;

        return response()->file($path); 
    }

    public function foto(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->candidato->foto_perfil;

        return response()->file($path); 
    }

    public function certificado(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->certificado;

        return response()->file($path); 
    }

    public function carta(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->carta;

        return response()->file($path); 
    }

    public function comprovacao(Request $request, $id)
    {
        $comprovacao = Comprovacao_Lattes_Arquivos::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$comprovacao->arquivo;

        return response()->file($path); 
    }

    public function recurso(Request $request, $id)
    {

        $candidaturas = Candidaturas::find($id);

        DB::beginTransaction();
        try{
            $recurso = Recursos::create([
            'candidato_id' => $candidaturas->candidato_id,
            'edital_id' => $candidaturas->edital_id,
            'description'=> $request->description,
            'replied' => false
        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

         try{
            $candidaturas->status_id = 16;
            $candidaturas->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/candidaturas');
       
    }

    public function atualizarStatus(Request $request, $id){

        $candidatura = Candidaturas::where('id', $id)->first();
        $statusTitulo = Status_Inscricao::where('titulo', $request->status)->first();
        $candidatura->status_id = $statusTitulo->id;
        $candidatura->save();


        return Redirect::back();
    }

    public function atualizarCertificado(Request $request, $id){

        $candidaturas = Candidaturas::where('id', $id)->first();

        $edital = Editais::where('id', $candidaturas->edital_id)->first();

        $this->validate($request, [
            'certificado' => 'file|max:8000',
            'carta' => 'file|max:8000',
        ]);

        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()){
            $certificado = $request->file('certificado')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$candidaturas->candidato->user_id, 'certificado');
        }else{
             $certificado =  $candidaturas->certificado;
        }

        if ($request->hasFile('carta') && $request->file('carta')->isValid()){
            $carta = $request->file('carta')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$candidaturas->candidato->user_id, 'carta');
        }else{
             $carta =  $candidaturas->carta;
        }

        try{
            $candidaturas->certificado = $certificado;
            $candidaturas->carta = $carta;
            $candidaturas->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return Redirect::back();
    }

    public function recursoDetalhes(Request $request, $id)
    {
        $recurso = Recursos::find($id);
        $resposta = Resposta_Recurso::where('recurso_id', $id)->first();

        $data = [
            'recurso' => $recurso,
            'resposta' => $resposta
        ]; 
       
          return view('candidaturas.recurso')->with($data);
    }

}
