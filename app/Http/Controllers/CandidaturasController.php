<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Editais;
use App\Candidato;
use App\Candidaturas;
use App\Convenios;
use App\Documento;
use App\Recursos;
use App\Resposta_Recurso;
use App\Status_Inscricao;
use App\Comprovacao_Lattes;
use App\Comprovacao_Lattes_Arquivos;
use App\Avaliacao_Ccint;
use App\Universidade_Edital;
use App\User;
use App\Notifications\UserSubscription;
use App\Notifications\ChangeStatus;
use App\Notifications\RecursoNotification;
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
            $candidaturas = Candidaturas::where('candidato_id', $candidato->id)->orderBy('id', 'desc')->get();
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
        $documentos =  Documento::all();

        $universidades = Universidade_Edital::where('edital_id', $edital->id)
        ->select('universidade_edital.*')
        ->join('convenios', 'convenios.universidade', '=', 'universidade_edital.nome')
        ->orderBy('convenios.pais')
        ->orderBy('convenios.universidade')
        ->get();

        $departamentos = DB::table('departamento')->get();

        $editalAeri = DB::table('programas')->where('id', 1)->first();

        $data = [
            'edital'        => $edital,
            'comprovacoes'  => $comprovacoes,
            'universidades' => $universidades,
            'departamentos' => $departamentos,
            'editalAeri'    => $editalAeri,
            'documentos'    => $documentos

        ]; 
        
        return view('candidaturas.inscricao')->with($data);
    }

    public function atualizacao(Request $request, $id)
    {

       $candidato = Candidato::where('user_id', Auth::user()->id)->first();

       $candidatura =  Candidaturas::where('candidato_id', $candidato->id)->where('edital_id', $id)->first();

       $comprovacoes =  Comprovacao_Lattes::all();

       $documentos =  Documento::all();

       $arquivos = Comprovacao_Lattes_Arquivos::where('candidatura_id', $candidatura->id)->get();

       $arquivos_documentos = DB::table('documento_arquivo')->where('candidatura_id', $candidatura->id)->get();

       $departamentos = DB::table('departamento')->get();

       $universidades = Universidade_Edital::where('edital_id', $candidatura->edital_id)
        ->select('universidade_edital.*')
        ->join('convenios', 'convenios.universidade', '=', 'universidade_edital.nome')
        ->orderBy('convenios.pais')
        ->orderBy('convenios.universidade')
        ->get();

       $count = 0;

        if($candidatura->primeira_opcao_universidade == null)
            $count++;
        if($candidatura->primeira_opcao_curso == null)
            $count++;
        if($candidatura->segunda_opcao_universidade == null)
            $count++;
        if($candidatura->segunda_opcao_curso == null)
            $count++;
        if($candidatura->terceira_opcao_universidade == null)
            $count++;
        if($candidatura->terceira_opcao_curso == null)
            $count++;
        if($candidatura->matricula == '0')
            $count++;
        if($candidatura->historico == '0')
            $count++;
        if($candidatura->percentual == '0')
            $count++;
        if($candidatura->curriculum == '0')
            $count++;
        if($candidatura->plano_trabalho1 == '0')
            $count++;
        if($candidatura->plano_trabalho2 == '0')
            $count++;
        if($candidatura->plano_trabalho3 == '0')
            $count++;
        if($candidatura->plano_estudo1 == '0')
            $count++;
        if($candidatura->plano_estudo2 == '0')
            $count++;
        if($candidatura->plano_estudo3 == '0')
            $count++;
        if($candidatura->professor_departamento_id == null)
            $count++;
        if($candidatura->nome_professor_carta == null)
            $count++;

        $editalAeri = DB::table('programas')->where('id', 1)->first();

        $edital = Editais::where('id', $candidatura->edital_id)->first();

        $data = [
            'candidatura'         => $candidatura,
            'arquivos'            => $arquivos,
            'comprovacoes'        => $comprovacoes,
            'documentos'          => $documentos,
            'arquivos_documentos' => $arquivos_documentos,
            'departamentos'       => $departamentos,
            'universidades'       => $universidades,
            'count'               => $count,
            'editalAeri'          => $editalAeri,
            'edital'              => $edital
        ]; 
       
        return view('candidaturas.atualizacao')->with($data);
    }

    public function update(Request $request, $id)
    {
        $editalAeri = DB::table('programas')->where('id', 1)->first();

        $candidatura = Candidaturas::find($id);

        $edital = Editais::where('id', $candidatura->edital_id)->first();

        if($edital->nome == $editalAeri->nome){
            $isFinished = $this->updateInscicaoEditalUefs($request, $id);
        }
        else{
            $isFinished = $this->updateInscicaEditalGenerico($request, $id);
        }

        return redirect('/home')->with('message', 'INSCRIÇÃO ATUALIZADA COM SUCESSO!');
    }

    public function updateInscicaEditalGenerico(Request $request, $id){

        $this->validate($request, [
            'matricula' => 'file|max:5000',
            'historico' => 'file|max:5000',
            'percentual' => 'file|max:5000',
            'curriculum' => 'file|max:5000'
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

        $candidato = Candidato::where('user_id', Auth::user()->id)->first();

        try{
            $candidaturas->matricula = $matricula;
            $candidaturas->historico = $historico;
            $candidaturas->percentual = $percentual;
            $candidaturas->curriculum = $curriculum;
            $candidaturas->nome_professor_carta = $request->nome_professor_carta;
            $candidaturas->professor_departamento_id = $request->professor_departamento_id;
            $candidaturas->status_id = 1;
            $candidaturas->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        $comprovacao = $request->comprovacao;
        $categoria = $request->categoria;

        if(!is_null($comprovacao)){
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
        }

        $documento = $request->documento;
        $anexos = $request->anexos;

        if(!is_null($documento)){
            for($count = 0; $count < count($documento); $count++)
            {

                if ($request->hasFile('documento.' . $count) && $request->file('documento.' . $count)->isValid()){

                    $arquivo = $request->file('documento.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                    DB::beginTransaction();
                        try{
                            $documento_arquivo = DB::table('documento_arquivo')->insert([
                            'candidatura_id' => $id,
                            'arquivo' => $arquivo,
                            'documento_id' => $request->anexos[$count]
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
        }

        return true;

    }

    public function updateInscicaoEditalUefs(Request $request, $id)
    {

        $this->validate($request, [
            'matricula' => 'file|max:5000',
            'historico' => 'file|max:5000',
            'percentual' => 'file|max:5000',
            'curriculum' => 'file|max:5000',
            'trabalho1' => 'file|max:5000',
            'trabalho2' => 'file|max:5000',
            'trabalho3' => 'file|max:5000',
            'estudo1' => 'file|max:5000',
            'estudo2' => 'file|max:5000',
            'estudo3' => 'file|max:5000',
            'certificado_proficiencia1' => 'file|max:5000',
            'certificado_proficiencia2' => 'file|max:5000',
            'certificado_proficiencia3' => 'file|max:5000',
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

        if ($request->hasFile('certificado_proficiencia1') && $request->file('certificado_proficiencia1')->isValid()){
            $certificado_proficiencia1 = $request->file('certificado_proficiencia1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia1');
        }else{
             $certificado_proficiencia1 = $candidaturas->certificado_proficiencia1;
        }
        if ($request->hasFile('certificado_proficiencia2') && $request->file('certificado_proficiencia2')->isValid()){
            $certificado_proficiencia2 = $request->file('certificado_proficiencia2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia2');
        }else{
             $certificado_proficiencia2 = $candidaturas->certificado_proficiencia2;
        }
        if ($request->hasFile('certificado_proficiencia3') && $request->file('certificado_proficiencia3')->isValid()){
            $certificado_proficiencia3 = $request->file('certificado_proficiencia3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia3');
        }else{
             $certificado_proficiencia3 = $candidaturas->certificado_proficiencia3;
        }
        if ($request->hasFile('carta') && $request->file('carta')->isValid()){
            $carta = $request->file('carta')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'carta');
        }else{
             $carta = 0;
        }

        $candidato = Candidato::where('user_id', Auth::user()->id)->first();
        $convenio1 = Convenios::where('universidade', $request->opcao1universidade)->first();
        $convenio2 = Convenios::where('universidade', $request->opcao2universidade)->first();
        $convenio3 = Convenios::where('universidade', $request->opcao3universidade)->first();

        try{
            $candidaturas->primeira_opcao_universidade = (!is_null($request->opcao1universidade)) ? $request->opcao1universidade : $candidaturas->primeira_opcao_universidade;
            $candidaturas->primeira_opcao_curso = (!is_null($request->opcao1curso)) ? $request->opcao1curso : $candidaturas->primeira_opcao_curso;
            $candidaturas->primeira_opcao_pais = (!is_null($convenio1->pais)) ?  $convenio1->pais : $candidaturas->primeira_opcao_pais;
            $candidaturas->segunda_opcao_universidade = (!is_null($request->opcao2universidade)) ? $request->opcao2universidade : $candidaturas->segunda_opcao_universidade;
            $candidaturas->segunda_opcao_curso = (!is_null($request->opcao2curso)) ? $request->opcao2curso : $candidaturas->segunda_opcao_curso;
            $candidaturas->segunda_opcao_pais = (!is_null($convenio2->pais)) ? $convenio2->pais : $candidaturas->segunda_opcao_pais;
            $candidaturas->terceira_opcao_universidade = (!is_null($request->opcao3universidade)) ? $request->opcao3universidade : $candidaturas->terceira_opcao_universidade;
            $candidaturas->terceira_opcao_curso = (!is_null($request->opcao3curso)) ? $request->opcao3curso : $candidaturas->terceira_opcao_curso;
            $candidaturas->terceira_opcao_pais = (!is_null($convenio3->pais)) ? $convenio3->pais : $candidaturas->terceira_opcao_pais;
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
            $candidaturas->certificado_proficiencia1 = $certificado_proficiencia1;
            $candidaturas->certificado_proficiencia2 = $certificado_proficiencia2;
            $candidaturas->certificado_proficiencia3 = $certificado_proficiencia3;
            $candidaturas->nome_professor_carta = $request->nome_professor_carta;
            $candidaturas->professor_departamento_id = $request->professor_departamento_id;
            $candidaturas->status_id = 17;
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

        $documento = $request->documento;
        $anexos = $request->anexos;


        for($count = 0; $count < count($documento); $count++)
        {

            if ($request->hasFile('documento.' . $count) && $request->file('documento.' . $count)->isValid()){

                $arquivo = $request->file('documento.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                DB::beginTransaction();
                    try{
                        $documento_arquivo = DB::table('documento_arquivo')->insert([
                        'candidatura_id' => $id,
                        'arquivo' => $arquivo,
                        'documento_id' => $request->anexos[$count]
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

        return $this->checkIsFinished($candidaturas);
    }

    public function details(Request $request, $id)
    {
        //pega candidato para garantir que um candidato so pode visualizar suas candidatuas
        $candidato = Candidato::where('user_id', Auth::user()->id)->first(); 

        $candidatura = Candidaturas::where('id', $id)->where('candidato_id', $candidato->id)->first();
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
        $editalAeri = DB::table('programas')->where('id', 1)->first();

        $edital = Editais::where('id', $id)->first();

        if($edital->nome == $editalAeri->nome){
            $isFinished = $this->storeEditalUefs($request, $id);
        }
        else{
            $isFinished = $this->storeEditalGenerico($request, $id);
        }

        if($isFinished)
            return redirect('/candidaturas')->with('message', "INSCRIÇÃO REALIZADA COM SUCESSO!");
        else
            return redirect('/candidaturas')->with('message', "INSCRIÇÃO SALVA COM SUCESSO!");
    }

    protected function storeEditalGenerico(Request $request, $id)
    {

        $edital = Editais::where('id', $id)->first();

        $universidade = Universidade_Edital::where('edital_id', $edital->id)
        ->select('universidade_edital.*')
        ->join('convenios', 'convenios.universidade', '=', 'universidade_edital.nome')
        ->orderBy('convenios.pais')
        ->orderBy('convenios.universidade')
        ->first();

        switch ($request->input('submitbutton')) {
            case 'Inscrever':

                $status = 1;
                $finalizado = true;

                $this->validate($request, [
                    'matricula' => 'required|file|max:5000',
                    'historico' => 'required|file|max:5000',
                    'percentual' => 'required|file|max:5000',
                    'curriculum' => 'required|file|max:5000',
                ]);

            break;

            case 'Salvar':

                $status = 17;
                $finalizado = false;

            break;
        }

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

        $candidato = Candidato::where('user_id', Auth::user()->id)->first();

        DB::beginTransaction();
        try{
            $candidatura = Candidaturas::create([
            'candidato_id' => $candidato->id,
            'edital_id' => $id,
            'primeira_opcao_universidade'=> 0,
            'primeira_opcao_curso' => 0,
            'primeira_opcao_pais' => 0,
            'segunda_opcao_universidade' => 0,
            'segunda_opcao_curso' => 0,
            'segunda_opcao_pais'=> 0,
            'terceira_opcao_universidade'=> 0,
            'terceira_opcao_curso'=> 0,
            'terceira_opcao_pais'=> 0,
            'matricula'=> $matricula,
            'historico'=> $historico,
            'percentual'=> $percentual,
            'curriculum'=> $curriculum,
            'plano_trabalho1'=> 0,
            'plano_trabalho2'=> 0,
            'plano_trabalho3'=> 0,
            'plano_estudo1'=> 0,
            'plano_estudo2'=> 0,
            'plano_estudo3'=> 0,
            'certificado_proficiencia1'=> 0,
            'certificado_proficiencia2'=> 0,
            'certificado_proficiencia3'=> 0,
            'status_id'=> $status,
            'carta'=> 0,
            'desempenho' => 0,
            'proficiencia_id1' => 0,
            'proficiencia_id2' => 0,
            'proficiencia_id3' => 0,
            'quarta_opcao_universidade' => 0,
            'quarta_opcao_curso' => 0,
            'quarta_opcao_pais' => 0,
            'nome_professor_carta' => (!is_null($request->nome_professor_carta)) ? $request->nome_professor_carta : '',
            'professor_departamento_id' => (!is_null($request->professor_departamento_id)) ? $request->professor_departamento_id : '',
            'plano_trabalho4' => 0,
            'plano_estudo4' => 0,
            'ies_anfitria' => 0,
            'finalizado' => $finalizado

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

        if(!is_null($comprovacao)){
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
        }

        $documento = $request->documento;
        $anexos = $request->anexos;

        if(!is_null($documento)){

            for($count = 0; $count < count($documento); $count++)
            {

                if ($request->hasFile('documento.' . $count) && $request->file('documento.' . $count)->isValid()){

                    $arquivo = $request->file('documento.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                    DB::beginTransaction();
                        try{
                            $documento_arquivo = DB::table('documento_arquivo')->insert([
                            'candidatura_id' => $candidatura->id,
                            'arquivo' => $arquivo,
                            'documento_id' => $request->anexos[$count]
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

        }

        if($finalizado)
            return true;
        else
            return false;

    }

    protected function storeEditalUefs(Request $request, $id)
    {

        $edital = Editais::where('id', $id)->first();

        switch ($request->input('submitbutton')) {
            case 'Inscrever':

                $this->validate($request, [
                    'matricula' => 'required|file|max:5000',
                    'historico' => 'required|file|max:5000',
                    'percentual' => 'required|file|max:5000',
                    'curriculum' => 'required|file|max:5000',
                    'trabalho1' => 'required|file|max:5000',
                    'trabalho2' => 'required|file|max:5000',
                    'trabalho3' => 'required|file|max:5000',
                    'estudo1' => 'required|file|max:5000',
                    'estudo2' => 'required|file|max:5000',
                    'estudo3' => 'required|file|max:5000',
                    'certificado_proficiencia1' => 'file|max:5000',
                    'certificado_proficiencia2' => 'file|max:5000',
                    'certificado_proficiencia3' => 'file|max:5000',
                ]);
            break;
        }
  

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

        if ($request->hasFile('certificado_proficiencia1') && $request->file('certificado_proficiencia1')->isValid()){
            $certificado_proficiencia1 = $request->file('certificado_proficiencia1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia1');
        }else{
             $certificado_proficiencia1 = 0;
        }
        if ($request->hasFile('certificado_proficiencia2') && $request->file('certificado_proficiencia2')->isValid()){
            $certificado_proficiencia2 = $request->file('certificado_proficiencia2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia2');
        }else{
             $certificado_proficiencia2 = 0;
        }
        if ($request->hasFile('certificado_proficiencia3') && $request->file('certificado_proficiencia3')->isValid()){
            $certificado_proficiencia3 = $request->file('certificado_proficiencia3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia3');
        }else{
             $certificado_proficiencia3 = 0;
        }
        if ($request->hasFile('carta') && $request->file('carta')->isValid()){
            $carta = $request->file('carta')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'carta');
        }else{
             $carta = 0;
        }

        $candidato = Candidato::where('user_id', Auth::user()->id)->first();
        $convenio1 = Convenios::where('universidade', $request->opcao1universidade)->first();
        $convenio2 = Convenios::where('universidade', $request->opcao2universidade)->first();
        $convenio3 = Convenios::where('universidade', $request->opcao3universidade)->first();



        DB::beginTransaction();
        try{
            $candidatura = Candidaturas::create([
            'candidato_id' => $candidato->id,
            'edital_id' => $id,
            'primeira_opcao_universidade'=> (!is_null($request->opcao1universidade)) ? $request->opcao1universidade : '',
            'primeira_opcao_curso' => (!is_null($request->opcao1curso)) ? $request->opcao1curso : '',
            'primeira_opcao_pais' => (!is_null($convenio1)) ? $convenio1->pais : '',
            'segunda_opcao_universidade' => (!is_null($request->opcao2universidade)) ? $request->opcao2universidade : '',
            'segunda_opcao_curso' => (!is_null($request->opcao2curso)) ? $request->opcao2curso : '',
            'segunda_opcao_pais'=> (!is_null($convenio2)) ? $convenio2->pais : '',
            'terceira_opcao_universidade'=> (!is_null($request->opcao3universidade)) ? $request->opcao3universidade : '',
            'terceira_opcao_curso'=> (!is_null($request->opcao3curso)) ? $request->opcao3curso : '',
            'terceira_opcao_pais'=> (!is_null($convenio3)) ? $convenio3->pais : '',
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
            'certificado_proficiencia1'=> $certificado_proficiencia1,
            'certificado_proficiencia2'=> $certificado_proficiencia2,
            'certificado_proficiencia3'=> $certificado_proficiencia3,
            'status_id'=> 17,
            'carta'=> $carta,
            'desempenho' => 0,
            'proficiencia_id1' => 0,
            'proficiencia_id2' => 0,
            'proficiencia_id3' => 0,
            'quarta_opcao_universidade' => 0,
            'quarta_opcao_curso' => 0,
            'quarta_opcao_pais' => 0,
            'nome_professor_carta' => $request->nome_professor_carta,
            'professor_departamento_id' => $request->professor_departamento_id,
            'plano_trabalho4' => 0,
            'plano_estudo4' => 0,
            'ies_anfitria' => 0,
            'finalizado' => false

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

        if(!is_null($comprovacao)){
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
        }

        $documento = $request->documento;
        $anexos = $request->anexos;

        if(!is_null($documento)){

            for($count = 0; $count < count($documento); $count++)
            {

                if ($request->hasFile('documento.' . $count) && $request->file('documento.' . $count)->isValid()){

                    $arquivo = $request->file('documento.' . $count)->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, date('mdYHis') . uniqid());

                    DB::beginTransaction();
                        try{
                            $documento_arquivo = DB::table('documento_arquivo')->insert([
                            'candidatura_id' => $candidatura->id,
                            'arquivo' => $arquivo,
                            'documento_id' => $request->anexos[$count]
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

        }

        return $this->checkIsFinished($candidatura);
    }

    public function deleteComprovante($id)
    {
        $comprovacao = Comprovacao_Lattes_Arquivos::find($id);
        $comprovacao->delete();
        return Redirect::back();
    }

    public function deleteDocumento($id)
    {
        $deleted = DB::table('documento_arquivo')->where('id', '=', $id)->delete();
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

    public function trabalho4(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_trabalho4;

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

    public function estudo4(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->plano_estudo4;

        return response()->file($path); 
    }

    public function foto(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->candidato->foto_perfil;

        return response()->file($path); 
    }

    public function certificado_proficiencia1(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->certificado_proficiencia1;

        return response()->file($path); 
    }

    public function certificado_proficiencia2(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->certificado_proficiencia2;

        return response()->file($path); 
    }

    public function certificado_proficiencia3(Request $request, $id)
    {
        $candidatura = Candidaturas::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$candidatura->certificado_proficiencia3;

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

    public function documento(Request $request, $id)
    {
        $documento = DB::table('documento_arquivo')->where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$documento->arquivo;

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

        $users = User::where('privilegio', 2)->orWhere('privilegio', 4)->get();

        foreach ($users as $user) {
            $user->notify(new RecursoNotification($recurso->id));    
        }

        return redirect('/candidaturas');
       
    }

    public function atualizarStatus(Request $request, $id){

        $candidatura = Candidaturas::where('id', $id)->first();
        $statusTitulo = Status_Inscricao::where('titulo', $request->status)->first();
        $candidatura->status_id = $statusTitulo->id;
        $candidatura->save();

        $user = User::where('id', $candidatura->candidato->user_id)->first();
        $user->notify(new ChangeStatus($candidatura->id));

        return Redirect::back()->with('message', 'STATUS ATUALIZADO COM SUCESSO!');
    }

    public function atualizarCandidatura(Request $request, $id){

        $candidaturas = Candidaturas::where('id', $id)->first();

        $edital = Editais::where('id', $candidaturas->edital_id)->first();

        if ($request->hasFile('certificado_proficiencia1') && $request->file('certificado_proficiencia1')->isValid()){
            $certificado_proficiencia1 = $request->file('certificado_proficiencia1')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia1');
        }else{
             $certificado_proficiencia1 = $candidaturas->certificado_proficiencia1;
        }

        if ($request->hasFile('certificado_proficiencia2') && $request->file('certificado_proficiencia2')->isValid()){
            $certificado_proficiencia2 = $request->file('certificado_proficiencia2')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia2');
        }else{
             $certificado_proficiencia2 = $candidaturas->certificado_proficiencia2;
        }

        if ($request->hasFile('certificado_proficiencia3') && $request->file('certificado_proficiencia3')->isValid()){
            $certificado_proficiencia3 = $request->file('certificado_proficiencia3')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$request->user()->id, 'certificado_proficiencia3');
        }else{
             $certificado_proficiencia3 = $candidaturas->certificado_proficiencia3;
        }

        if ($request->hasFile('carta') && $request->file('carta')->isValid()){
            $carta = $request->file('carta')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$candidaturas->candidato->user_id, 'carta');
        }else{
             $carta =  $candidaturas->carta;
        }

        if($request->has('desempenho')){
           $desempenho = $request->desempenho;
        }else{
            $desempenho = $candidaturas->desempenho;
        }

        if($request->has('proficiencia_id1')){
            $proficiencia_id1 = $request->proficiencia_id1;
        }else{
            $proficiencia_id1 = $candidaturas->proficiencia_id1;
        }

        if($request->has('proficiencia_id2')){
            $proficiencia_id2 = $request->proficiencia_id2;
        }else{
            $proficiencia_id2 = $candidaturas->proficiencia_id2;
        }

        if($request->has('proficiencia_id3')){
            $proficiencia_id3 = $request->proficiencia_id3;
        }else{
            $proficiencia_id3 = $candidaturas->proficiencia_id3;
        }

        if($request->has('opcao4universidade')){
            $opcao4universidade = $request->opcao4universidade;
            $opcao4curso = $request->opcao4curso;
        }else{
            $opcao4universidade = $candidaturas->quarta_opcao_universidade;
            $opcao4curso = $candidaturas->quarta_opcao_curso;
        }

        if ($request->hasFile('plano_trabalho4') && $request->file('plano_trabalho4')->isValid()){
            $plano_trabalho4 = $request->file('plano_trabalho4')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$candidaturas->candidato->user_id, 'trabalho4');
        }else{
             $plano_trabalho4 =  $candidaturas->plano_trabalho4;
        }

        if ($request->hasFile('plano_estudo4') && $request->file('plano_estudo4')->isValid()){
            $plano_estudo4 = $request->file('plano_estudo4')->storeAs('editais'.'/'.$edital->nome.'/'.$edital->numero.'/'.'users/'.$candidaturas->candidato->user_id, 'estudo4');
        }else{
             $plano_estudo4 =  $candidaturas->plano_estudo4;
        }

        try{
            $candidaturas->carta = $carta;
            $candidaturas->desempenho = $desempenho;
            $candidaturas->certificado_proficiencia1 = $certificado_proficiencia1;
            $candidaturas->certificado_proficiencia2 = $certificado_proficiencia2;
            $candidaturas->certificado_proficiencia3 = $certificado_proficiencia3;
            $candidaturas->proficiencia_id1 = $proficiencia_id1;
            $candidaturas->proficiencia_id2 = $proficiencia_id2;
            $candidaturas->proficiencia_id3 = $proficiencia_id3;
            $candidaturas->quarta_opcao_universidade = $opcao4universidade;
            $candidaturas->quarta_opcao_curso = $opcao4curso;
            $candidaturas->plano_trabalho4 = $plano_trabalho4;
            $candidaturas->plano_estudo4 = $plano_estudo4;
            $candidaturas->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return Redirect::back()->with('message', 'DADOS ATUALIZADOS COM SUCESSO!');
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

    public function checkIsFinished($candidatura){


        $isFinished = true;

        if($candidatura->primeira_opcao_universidade == null){
            $isFinished = false;
        }
        if($candidatura->primeira_opcao_curso == null){
            $isFinished = false;
        }
        if($candidatura->segunda_opcao_universidade == null){
            $isFinished = false;
        }
        if($candidatura->segunda_opcao_curso == null){
            $isFinished = false;
        }
        if($candidatura->terceira_opcao_universidade == null){
            $isFinished = false;
        }
        if($candidatura->terceira_opcao_curso == null){
            $isFinished = false;
        }
        if($candidatura->matricula == '0'){
            $isFinished = false;
        }
        if($candidatura->historico == '0'){
            $isFinished = false;
        }
        if($candidatura->percentual == '0'){
            $isFinished = false;
        }
        if($candidatura->curriculum == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_trabalho1 == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_trabalho2 == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_trabalho3 == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_estudo1 == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_estudo2 == '0'){
            $isFinished = false;
        }
        if($candidatura->plano_estudo3 == '0'){
            $isFinished = false;
        }
        if($candidatura->professor_departamento_id == null){
            $isFinished = false;
        }
        if($candidatura->nome_professor_carta == null){
            $isFinished = false;
        }

        if($isFinished){
            $users = User::where('privilegio', 2)->orWhere('privilegio', 4)->get();

            //Se ainda não foi notificado
            if(!$candidatura->finalizado){

                foreach ($users as $user) {
                    $user->notify(new UserSubscription($candidatura->id));            
                }
            }

            $status_id = 1;
        }
        else{
            $status_id = 17;
        }

        try{
            $candidatura->finalizado = $isFinished;
            $candidatura->status_id = $status_id;
            $candidatura->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return $isFinished;
    }

}
