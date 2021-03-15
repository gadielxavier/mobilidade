<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Editais;
use App\Candidaturas;
use App\Status_Inscricao;
use App\Status_Edital;
use App\User;
use App\Avaliacao_Ccint;
use App\Convenios;
use App\Universidade_Edital;
use App\Notifications\ChangeStatus;
use App\Proeficiencia;
use DB, Log, PDF;
use Redirect;

class EditaisController extends Controller
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

    public function index()
    {
    	$editais = Editais::orderBy('id', 'desc')->paginate(10);
        $convenios = Convenios::where('status', '1')->get();

    	$data = [
            'editais' => $editais,
            'convenios' => $convenios
        ];

        return view('editais.editais')->with($data);
    }

    public function download(Request $request, $id)
    {
        //dd($request);
        $edital = Editais::where('id', $id)->first();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $storagePath.$edital->path_anexo;

        return response()->file($path); 
    }

    /**
     * Create a new edital instance.
     *
     * @param  Request  $request
     * @return Response
     */
    protected function store(Request $request)
    {
        // Validate the request...

        $this->validate($request, [
            'fim_inscricao' => 'required|date_format:Y-m-d',
            'nome' => 'required|string|max:255',
            'anexo' => 'required|file|max:5000'
        ]);


        DB::beginTransaction();
        try{

            if ($request->hasFile('anexo') && $request->file('anexo')->isValid()){
                $anexo = $request->file('anexo')->storeAs('editais'.'/'.$request->nome.'/'.$request->numero, 'anexo');
            }

            $edital = Editais::create([
            'fim_inscricao' => $request->fim_inscricao,
            'nome' => $request->nome,
            'numero' => $request->numero,
            'qtd_bolsas'=> $request->bolsas,
            'status_edital_id'=> '1',
            'path_anexo'=> $anexo,
            'maior_pontuacao' => 0,
            'inicio_inscricao' => $request->inicio_inscricao,
            'homologacoes_inscricoes' => $request->homologacoes_inscricoes,
            'inicio_recurso_inscricao' => $request->inicio_recurso_inscricao,
            'fim_recurso_inscricao' => $request->fim_recurso_inscricao,
            'homologacao_final' => $request->homologacao_final,
            'inicio_proeficiencia' => $request->inicio_proeficiencia,
            'fim_proeficiencia' => $request->fim_proeficiencia,
            'aprovados_primeira_fase' => $request->aprovados_primeira_fase,
            'inicio_recurso_primeira_fase' => $request->inicio_recurso_primeira_fase,
            'fim_recurso_primeira_fase' => $request->fim_recurso_primeira_fase,
            'resultado_final_primeira_fase' => $request->resultado_final_primeira_fase,
            'inicio_ccint' => $request->inicio_ccint,
            'fim_ccint' => $request->fim_ccint,
            'resultado_segunda_fase' => $request->resultado_segunda_fase,
            'inicio_recurso_segunda_fase' => $request->inicio_recurso_segunda_fase,
            'fim_recurso_segunda_fase' => $request->fim_recurso_segunda_fase,
            'resultado_final_segunda_fase' => $request->resultado_final_segunda_fase,
            'reuniao_esclarecimentos' => $request->reuniao_esclarecimentos,
            'inicio_entrega_documentos' => $request->inicio_entrega_documentos,
            'fim_entrega_documentos' => $request->fim_entrega_documentos,
            'inicio_avaliacao_documentos' => $request->inicio_avaliacao_documentos,
            'fim_avaliacao_documentos' => $request->fim_avaliacao_documentos,
            'envio_candidaturas' => $request->envio_candidaturas,
            'inicio_recepcao_carta' => $request->inicio_recepcao_carta,
            'fim_recepcao_carta' => $request->fim_recepcao_carta,
            'divulgacao_resultado_terceira_fase' => $request->divulgacao_resultado_terceira_fase,
            'inicio_aquisicoes' => $request->inicio_aquisicoes,
            'inicio_mobilidade' => $request->inicio_mobilidade

        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        $universidades = $request->universidade;
        $vagas = $request->vagas;


        for($count = 0; $count < count($universidades); $count++)
        {

            DB::beginTransaction();
            try{

                $universidadeEdital = Universidade_Edital::create([
                'nome' => $universidades[$count],
                'vagas' => $vagas[$count],
                'edital_id' => $edital->id
            ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }
        

        return redirect('/editais')->with('message', 'EDITAL CADASTRADO COM SUCESSO!');
    }

    public function details(Request $request, $id)
    {
        $edital = Editais::find($id);
        $candidaturas = Candidaturas::where('edital_id', $id)->where('status_id', '!=', 17)->paginate(30);
        $status =  Status_Inscricao::all();
        $avaliadores = User::where('privilegio', 3)->get(); 

        $data = [
            'edital' => $edital,
            'candidaturas' => $candidaturas,
            'status' => $status,
            'avaliadores' => $avaliadores
        ]; 
       
          return view('editais.detalhes')->with($data);
    }

    public function deleteUniversidade($id)
    {
        $universidade = Universidade_Edital::find($id);
        $universidade->delete();
        return Redirect::back();
    }

    public function atualizar(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();
        $status = Status_Edital::all();
        $convenios = Convenios::where('status', '1')->get();
        $universidades = Universidade_Edital::where('edital_id', $edital->id)->get();
            

        $data = [
            'edital' => $edital,
            'status' => $status,
            'convenios' => $convenios,
            'universidades' => $universidades
        ]; 
       
          return view('editais.atualizar')->with($data);
    }

    // Generate PDF
    public function createPDF(Request $request, $id) {


        $edital = Editais::where('id', $id)->first();
        $status = Status_Edital::all();
        $avaliacoes = Avaliacao_Ccint::where('edital_id', $edital->id)
        ->orderBy('nota_final', 'desc')->get();

        $universidades = Universidade_Edital::where('edital_id', $edital->id)->get();

        $universidades_nome_array = [];

        foreach ($universidades as $universidade) {
            $universidades_nome_array = array_add($universidades_nome_array, $universidade->nome, array());    
        }

        foreach ($avaliacoes as $avaliacao) {

            $opcao1 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->primeira_opcao_universidade)->first();
            $opcao2 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->segunda_opcao_universidade)->first();
            $opcao3 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->terceira_opcao_universidade)->first();

            $convenio = Convenios::where('universidade', $avaliacao->candidatura->primeira_opcao_universidade)->first();

            $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

            $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id1)->first();

            $candidatura = Candidaturas::where('id', $avaliacao->candidatura->id)->first();


            /* Se a universidade ainda tem vagas disponiveis. Se tiver, verifica se a universidade
            exige proeficiencia. Se exigir, verifica se o aluno tem proeficiencia maior ou igual da universidade
            */
            if((count($universidades_nome_array[$opcao1->nome]) <  $opcao1->vagas)
            &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                $universidades_nome_array[$opcao1->nome][] = $avaliacao->candidatura->candidato->nome;

                try{
                    $candidatura->ies_anfitria = $opcao1->nome;
                    $candidatura->save();

                }
                catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e);
                    return $this->error($e->getMessage(), 500, $e);
                }


            }else{

                //atualiza a proeficiencia da universidade
                $convenio = Convenios::where('universidade', $avaliacao->candidatura->segunda_opcao_universidade)->first();

                $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

                $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id2)->first();

                //Caso candidato não tenha conseguido primeira opção verifica 2
                if( (count($universidades_nome_array[$opcao2->nome]) <  $opcao2->vagas )
                &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                    $universidades_nome_array[$opcao2->nome][] = $avaliacao->candidatura->candidato->nome;

                    try{
                        $candidatura->ies_anfitria = $opcao2->nome;
                        $candidatura->save();

                    }
                    catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e);
                        return $this->error($e->getMessage(), 500, $e);
                    }
                    

                }else{

                    //atualiza a proeficiencia da universidade
                    $convenio = Convenios::where('universidade', $avaliacao->candidatura->terceira_opcao_universidade)->first();

                    $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

                    $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id3)->first();

                    //Caso candidato não tenha conseguido segunda opção verifica 3
                    if((count($universidades_nome_array[$opcao3->nome]) <  $opcao3->vagas )
                    &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                        $universidades_nome_array[$opcao3->nome][] = $avaliacao->candidatura->candidato->nome;

                        try{
                            $candidatura->ies_anfitria = $opcao3->nome;
                            $candidatura->save();

                        }
                        catch(\Exception $e) {
                            DB::rollback();
                            Log::error($e);
                            return $this->error($e->getMessage(), 500, $e);
                        }
                    }
                }
            }
        }

        $data = [
            'edital' => $edital,
            'avaliacoes' => $avaliacoes,
            'status' => $status,
            'classificacoes' => array_divide($universidades_nome_array),
            'universidades' => $universidades
        ]; 

        // share data to view
        view()->share(['edital', 'avaliacoes', 'status', 'classificacoes', 'universidades'],$data);
        $pdf = PDF::loadView('editais.pdf', $data);

        // Finally, you can download the file using download function
        return $pdf->download('tabela.pdf');
    }


    public function resultado(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();
        $status = Status_Edital::all();
        $avaliacoes = Avaliacao_Ccint::where('edital_id', $edital->id)
        ->orderBy('nota_final', 'desc')->get();

        $universidades = Universidade_Edital::where('edital_id', $edital->id)->get();

        $universidades_nome_array = [];

        foreach ($universidades as $universidade) {
            $universidades_nome_array[$universidade->nome] = array();   
        }

        foreach ($avaliacoes as $avaliacao) {

            $opcao1 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->primeira_opcao_universidade)->first();
            $opcao2 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->segunda_opcao_universidade)->first();
            $opcao3 = Universidade_Edital::where('edital_id', $edital->id)->where('nome', $avaliacao->candidatura->terceira_opcao_universidade)->first();

            $convenio = Convenios::where('universidade', $avaliacao->candidatura->primeira_opcao_universidade)->first();

            $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

            $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id1)->first();

            $candidatura = Candidaturas::where('id', $avaliacao->candidatura->id)->first();


            /* Se a universidade ainda tem vagas disponiveis. Se tiver, verifica se a universidade
            exige proeficiencia. Se exigir, verifica se o aluno tem proeficiencia maior ou igual da universidade
            */
            if( isset($universidades_nome_array[$opcao1->nome]) 
                && isset($proficiencia_aluno->nota)
                && (count($universidades_nome_array[$opcao1->nome]) <  $opcao1->vagas)
                &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                $universidades_nome_array[$opcao1->nome][] = $avaliacao->candidatura->candidato->nome;

                try{
                    $candidatura->ies_anfitria = $opcao1->nome;
                    $candidatura->save();

                }
                catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e);
                    return $this->error($e->getMessage(), 500, $e);
                }


            }else{

                //atualiza a proeficiencia da universidade
                $convenio = Convenios::where('universidade', $avaliacao->candidatura->segunda_opcao_universidade)->first();

                $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

                $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id2)->first();

                //Caso candidato não tenha conseguido primeira opção verifica 2
                if( isset($universidades_nome_array[$opcao2->nome])
                    && isset($proficiencia_aluno->nota) 
                    && (count($universidades_nome_array[$opcao2->nome]) <  $opcao2->vagas )
                    &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                    $universidades_nome_array[$opcao2->nome][] = $avaliacao->candidatura->candidato->nome;

                    try{
                        $candidatura->ies_anfitria = $opcao2->nome;
                        $candidatura->save();

                    }
                    catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e);
                        return $this->error($e->getMessage(), 500, $e);
                    }
                    

                }else{

                    //atualiza a proeficiencia da universidade
                    $convenio = Convenios::where('universidade', $avaliacao->candidatura->terceira_opcao_universidade)->first();

                    $proficiencia_universidade = Proeficiencia::where('id', $convenio->proeficiencia_id)->first();

                    $proficiencia_aluno = Proeficiencia::where('id', $avaliacao->candidatura->proficiencia_id3)->first();

                    //Caso candidato não tenha conseguido segunda opção verifica 3
                    if( isset($universidades_nome_array[$opcao3->nome])
                        && isset($proficiencia_aluno->nota) 
                        && (count($universidades_nome_array[$opcao3->nome]) <  $opcao3->vagas )
                        &&  ( ($proficiencia_universidade->id == 1) || ($proficiencia_aluno->nota >= $proficiencia_universidade->nota) && ($proficiencia_universidade->lingua == $proficiencia_aluno->lingua) ) ){

                        $universidades_nome_array[$opcao3->nome][] = $avaliacao->candidatura->candidato->nome;

                        try{
                            $candidatura->ies_anfitria = $opcao3->nome;
                            $candidatura->save();

                        }
                        catch(\Exception $e) {
                            DB::rollback();
                            Log::error($e);
                            return $this->error($e->getMessage(), 500, $e);
                        }
                    }
                }
            }
        }

        $data = [
            'edital' => $edital,
            'avaliacoes' => $avaliacoes,
            'status' => $status,
            'classificacoes' => array_divide($universidades_nome_array),
            'universidades' => $universidades
        ]; 
       
          return view('editais.resultado')->with($data);
    }

    public function atualizarResultado(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();

        for ($i = 0; $i<count($request->input('avaliacoes'));  $i++) {

            $avaliacao = Avaliacao_Ccint::where('id', $request->input('avaliacoes')[$i])->first();

            $desempenho_academico = $avaliacao->candidatura->desempenho;

            if($edital->maior_pontuacao > 0){
                $curriculum_lattes = 10 * $avaliacao->curriculum_lattes / $edital->maior_pontuacao;
            }else{
                $curriculum_lattes = 0;
            }

            $nota_final = (2*$avaliacao->carta+2*$curriculum_lattes+2*$avaliacao->plano_trabalho+4*$desempenho_academico)/10;

            try{
                $avaliacao->desempenho_academico = $desempenho_academico;
                $avaliacao->nota_final = $nota_final;
                $avaliacao->save();

            }
            catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            } 
            
        }

        $posicao = 1;

        $avaliacoes = DB::table('avaliacao_ccint')
                ->where('edital_id', $id)
                ->orderBy('nota_final', 'desc')
                ->get();


        foreach ($avaliacoes as $avaliacao) {

            $avaliacao = Avaliacao_Ccint::where('id', $avaliacao->id)->first();

            try{
                $avaliacao->posicao = $posicao;
                $avaliacao->save();

            }
            catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }

            $posicao++; 
            
        }



        return Redirect::back()->with('message', 'RESULTADO ATUALIZADOS COM SUCESSO!');

    }

    public function atualizarResultadoSegundaFase(Request $request, $id)
    {

        for ($i = 0; $i<count($request->input('avaliacoes'));  $i++) {


            $avaliacao = Avaliacao_Ccint::where('id', $request->input('avaliacoes')[$i])->first();

            $candidatura = Candidaturas::where('id', $avaliacao->candidatura->id)->first();

            try{
                $candidatura->ies_anfitria = $request->input('universidades')[$i];
                $candidatura->save();

            }
            catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }            
        }

        return Redirect::back()->with('message', 'RESULTADO ATUALIZADOS COM SUCESSO!');

    }

    public function update(Request $request, $id)
    {

        // Validate the request...

        $this->validate($request, [
            'fim_inscricao' => 'required|date_format:Y-m-d',
            'nome' => 'required|string|max:255',
            'path_anexo' => 'file|max:5000',
        ]);

        $edital = Editais::find($id);

        if ($request->hasFile('anexo') && $request->file('anexo')->isValid()){

            Storage::delete($edital->path_anexo);

            $anexo = $request->file('anexo')->storeAs('editais'.'/'.$request->nome.'/'.$request->numero, 'anexo');
        }
        else{
            $anexo = $edital->path_anexo;
        }


        try{
            $edital->nome =  $request->nome;
            $edital->numero = $request->numero;
            $edital->qtd_bolsas = $request->bolsas;
            $edital->status_edital_id = $request->status;
            $edital->path_anexo = $anexo;
            $edital->inicio_inscricao = $request->inicio_inscricao;
            $edital->fim_inscricao = $request->fim_inscricao;
            $edital->homologacoes_inscricoes = $request->homologacoes_inscricoes;
            $edital->inicio_recurso_inscricao = $request->inicio_recurso_inscricao;
            $edital->fim_recurso_inscricao = $request->fim_recurso_inscricao;
            $edital->homologacao_final = $request->homologacao_final;
            $edital->inicio_proeficiencia = $request->inicio_proeficiencia;
            $edital->fim_proeficiencia = $request->fim_proeficiencia;
            $edital->aprovados_primeira_fase = $request->aprovados_primeira_fase;
            $edital->inicio_recurso_primeira_fase = $request->inicio_recurso_primeira_fase;
            $edital->fim_recurso_primeira_fase = $request->fim_recurso_primeira_fase;
            $edital->resultado_final_primeira_fase = $request->resultado_final_primeira_fase;
            $edital->inicio_ccint = $request->inicio_ccint;
            $edital->fim_ccint = $request->fim_ccint;
            $edital->resultado_segunda_fase = $request->resultado_segunda_fase;
            $edital->inicio_recurso_segunda_fase = $request->inicio_recurso_segunda_fase;
            $edital->fim_recurso_segunda_fase = $request->fim_recurso_segunda_fase;
            $edital->resultado_final_segunda_fase = $request->resultado_final_segunda_fase;
            $edital->reuniao_esclarecimentos = $request->reuniao_esclarecimentos;
            $edital->inicio_entrega_documentos = $request->inicio_entrega_documentos;
            $edital->fim_entrega_documentos = $request->fim_entrega_documentos;
            $edital->inicio_avaliacao_documentos = $request->inicio_avaliacao_documentos;
            $edital->fim_avaliacao_documentos = $request->fim_avaliacao_documentos;
            $edital->envio_candidaturas = $request->envio_candidaturas;
            $edital->inicio_recepcao_carta = $request->inicio_recepcao_carta;
            $edital->fim_recepcao_carta = $request->fim_recepcao_carta;
            $edital->divulgacao_resultado_terceira_fase = $request->divulgacao_resultado_terceira_fase;
            $edital->inicio_aquisicoes = $request->inicio_aquisicoes;
            $edital->inicio_mobilidade = $request->inicio_mobilidade;
            $edital->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        $universidades = $request->universidade;
        $vagas = $request->vagas;


        for($count = 0; $count < count($universidades); $count++)
        {

            DB::beginTransaction();
            try{

                $universidadeEdital = Universidade_Edital::create([
                'nome' => $universidades[$count],
                'vagas' => $vagas[$count],
                'edital_id' => $edital->id
            ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }


        return redirect('/editais/detalhes/'.$edital->id )->with('message', 'EDITAL ATUALIZADO COM SUCESSO!');
    }

    public function candidatura(Request $request, $id)
    {
        $candidatura =  Candidaturas::find($id);
        $status =  Status_Inscricao::all();
        $proeficiencias = Proeficiencia::all();
        $universidades = Universidade_Edital::where('edital_id', $candidatura->edital_id)->get();
        $avaliacao = Avaliacao_Ccint::where('candidatura_id', $candidatura->id)->first();

        $data = [
            'candidatura'    => $candidatura,
            'status'         => $status,
            'proeficiencias' => $proeficiencias,
            'universidades'  => $universidades,
            'avaliacao'      => $avaliacao
        ]; 

        return view('editais.candidatura')->with($data);
    }

    public function destroy($id)
    {
        $candidaturas = Candidaturas::where('edital_id', $id)->get();

         foreach ($candidaturas as $candidatura) {
             $candidatura->delete();
         }

        $edital = Editais::find($id);
        $edital->delete();
        return redirect('/editais');
    }

     public function ccint(Request $request)
    {

        if($request->input('candidatura') == null){
            return redirect('/editais');
        }

        foreach ($request->input('candidatura') as $candidatura_id) {

            $candidatura =  Candidaturas::find($candidatura_id);

            if($request->status != null){

                try{

                    $candidatura->status_id =  $request->status;
                    $candidatura->save();

                    $user = User::where('id', $candidatura->candidato->user_id)->first();

                    $notifications = $user
                    ->notifications
                    ->where('type', 'App\Notifications\ChangeStatus')
                    ->all();

                    foreach ($notifications as $notification) {
                        $notification->markAsRead();
                    }

                    $user->notify(
                        (new ChangeStatus($candidatura->id))->delay(Carbon::now()->addMinutes(1))
                    );

                    if(env('MAIL_HOST', false) == 'smtp.mailtrap.io'){
                        sleep(1); //use usleep(500000) for half a second or less
                    }

                }
                catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e);
                    return $this->error($e->getMessage(), 500, $e);
                }

            }

            if($request->avaliador != null){

                $avaliacao = Avaliacao_Ccint::where('candidatura_id', $candidatura->id)->first();

                if($avaliacao != null){

                    $avaliacao->delete();
                }

                DB::beginTransaction();
                try{
                    $avaliacaoCcint = Avaliacao_Ccint::create([
                    'candidatura_id' => $candidatura->id,
                    'avaliador_id' => $request->avaliador,
                    'desempenho_academico' => 0,
                    'plano_trabalho' => 0,
                    'curriculum_lattes' => 0,
                    'carta' => 0,
                    'nota_final' => 0,
                    'finalizado' => false,
                    'edital_id' => $candidatura->edital_id,
                    'posicao' => 0,
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

        return redirect('/editais/detalhes/'.$candidatura->edital->id )->with('message', 'INSCRIÇŌES ATUALIZADAS COM SUCESSO!');

    }
}
