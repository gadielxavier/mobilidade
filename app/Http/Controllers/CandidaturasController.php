<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Editais;
use App\Candidato;
use App\Candidaturas;
use App\Status_Inscricao;
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
        $candidaturas = Candidaturas::where('candidato_id', Auth::user()->id)->get(); 

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

        $data = [
            'edital' => $edital
        ]; 
        
        return view('candidaturas.inscricao')->with($data);
    }

    public function atualizacao(Request $request, $id)
    {

       $candidatura =  Candidaturas::where('candidato_id', Auth::user()->id)->where('edital_id', $id)->first();

        $data = [
            'candidatura' => $candidatura
        ]; 
       
        return view('candidaturas.atualizacao')->with($data);
    }

    public function update(Request $request, $id)
    {
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
             $matricula =  $candidaturas->historico;
        }

        if ($request->hasFile('percentual') && $request->file('percentual')->isValid()){
            $percentual = $request->file('percentual')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'percentual');
        }else{
             $matricula =  $candidaturas->percentual;
        }

        if ($request->hasFile('curriculum') && $request->file('curriculum')->isValid()){
            $curriculum = $request->file('curriculum')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'curriculum');
        }else{
             $matricula =  $candidaturas->curriculum;
        }

        if ($request->hasFile('trabalho1') && $request->file('trabalho1')->isValid()){
            $trabalho1 = $request->file('trabalho1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho1');
        }else{
             $matricula =  $candidaturas->plano_trabalho1;
        }

        if ($request->hasFile('trabalho2') && $request->file('trabalho2')->isValid()){
            $trabalho2 = $request->file('trabalho2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho2');
        }else{
             $matricula =  $candidaturas->plano_trabalho2;
        }

        if ($request->hasFile('trabalho3') && $request->file('trabalho3')->isValid()){
            $trabalho3 = $request->file('trabalho3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'trabalho3');
        }else{
             $matricula =  $candidaturas->plano_trabalho3;
        }

        if ($request->hasFile('estudo1') && $request->file('estudo1')->isValid()){
            $estudo1 = $request->file('estudo1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo1');
        }else{
             $matricula =  $candidaturas->plano_estudo1;
        }

        if ($request->hasFile('estudo2') && $request->file('estudo2')->isValid()){
            $estudo2 = $request->file('estudo2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo2');
        }else{
             $matricula =  $candidaturas->plano_estudo2;
        }

        if ($request->hasFile('estudo3') && $request->file('estudo3')->isValid()){
            $estudo3 = $request->file('estudo3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'estudo3');
        }else{
             $matricula =  $candidaturas->plano_estudo3;
        }

        if ($request->hasFile('certificado') && $request->file('certificado')->isValid()){
            $certificado = $request->file('certificado')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado');
        }else{
             $matricula =  $candidaturas->certificado;
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

        return redirect('/home');
    }

    public function details(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $data = [
            'candidatura' => $candidatura
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


        DB::beginTransaction();
        try{
            $candidatura = Candidaturas::create([
            'candidato_id' => Auth::user()->id,
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
            'status_id'=> 1
        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/candidaturas');

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

    public function atualizarStatus(Request $request, $id){

        $candidatura = Candidaturas::where('id', $id)->first();
        $statusTitulo = Status_Inscricao::where('titulo', $request->status)->first();
        $candidatura->status_id = $statusTitulo->id;
        $candidatura->save();


        return redirect('/home');

    }
}
