<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstudantesInternacionais;
use App\Programa;
use App\Candidaturas;
use App\Cursos;
use App\Convenios;
use App\Editais;
use App\Candidato;
use DB, Log;

class EstudanteController extends Controller
{
    public function estudantesInternacionais(Request $request)
    {

        // Filtros
        $filtroPais = $request->input('filtro-pais');
        $filtroPrograma = $request->input('filtro-programa');

    	$estudantes = EstudantesInternacionais::orderBy('nome');

        if($filtroPais) {
            $estudantes = $estudantes->where('pais', $filtroPais);
         }

         if($filtroPrograma) {
            $estudantes = $estudantes->where('programa', $filtroPrograma);
         }

         $estudantes = $estudantes->paginate(50);
         $paises = DB::table('pais')->orderBy('pais_nome')->get();
         $programas = Programa::where('tipo', '1')->get();
         $cursos = Cursos::all();
         $departamentos = DB::table('departamento')->get(); 
         $posGraduacoes = DB::table('pos_graduacao')->get(); 

    	$data = [
            'estudantes'    => $estudantes,
            'paises'        => $paises,
            'programas'     => $programas,
            'cursos'        => $cursos,
            'departamentos' => $departamentos,
            'posGraduacoes' => $posGraduacoes
        ];
        
        return view('estudantes.internacionais')->with($data);
    }

    public function estudantesUefs(Request $request)
    {
        // Filtros
        $filtroCurso = $request->input('filtro-curso');
        $filtroPrograma = $request->input('filtro-programa');

        $estudantes = Candidaturas::where('status_id', 14)
            ->with('candidato')
            ->select('candidaturas.*')
            ->join('candidatos', 'candidatos.id', '=', 'candidaturas.candidato_id')
            ->orderBy('candidatos.nome');

        if($filtroCurso) {
            $estudantes = $estudantes->where('candidatos.curso', $filtroCurso);
         }

         if($filtroPrograma) {
            $estudantes = $estudantes->join('editais', 'editais.id', '=', 'candidaturas.edital_id')->where('editais.nome', $filtroPrograma);
         }

        $estudantes = $estudantes->paginate(50);

        $cursos = Cursos::all();

        $paises = DB::table('pais')->get();

        $programas = Programa::where('tipo', '2')->get();

        $convenios = Convenios::orderBy('pais')->orderBy('universidade')->get();

        $data = [
            'estudantes' => $estudantes,
            'cursos'     => $cursos,
            'paises'     => $paises,
            'convenios'  => $convenios,
            'programas'  => $programas,
        ];
        
        return view('estudantes.uefs')->with($data);
    }

    function addEstudanteInternacional(Request $request){

        $estudante = EstudantesInternacionais::where('nome', $request->nome)
                        ->where('pais', $request->pais)->first();

        if(empty($estudante)){
            DB::beginTransaction();
            try{

                $estudante = EstudantesInternacionais::create([
                    'nome' => $request->nome,
                    'pais' => $request->pais,
                    'programa'=> $request->programa,
                    'modalidade'=> $request->modalidade,
                    'inicio'=> $request->inicio,
                    'final' => $request->final,
                    'sexo'  => $request->sexo,
                    'vinculo' => $request->vinculo
                ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        return redirect('/estudantes/internacionais')->with('message', 'ESTUDANTE ADICIONADO COM SUCESSO!');
    }

    public function updateInternacionais(Request $request, $id)
    {
        $estudante = EstudantesInternacionais::find($id);

        try{

            $estudante->nome =  $request->nome;
            $estudante->pais =  $request->pais;
            $estudante->programa =  $request->programa;
            $estudante->modalidade =  $request->modalidade;
            $estudante->inicio =  $request->inicio;
            $estudante->final =  $request->final;
            $estudante->sexo = $request->sexo;
            $estudante->vinculo = $request->vinculo;
            $estudante->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        return redirect('/estudantes/internacionais' )->with('message', 'Programa ATUALIZADO COM SUCESSO!');
    }

    function addEstudanteUefs(Request $request){

        $edital = Editais::where('nome', $request->programa)
                        ->where('numero', $request->numero)->first();

        if(empty($edital)){
            DB::beginTransaction();
            try{

                $edital = Editais::create([
                    'fim_inscricao' => $request->data_edital,
                    'nome' => $request->programa,
                    'numero' => $request->numero,
                    'qtd_bolsas'=> 1,
                    'status_edital_id'=> 20,
                    'path_anexo'=> 'avatars/0/documento.pdf',
                    'maior_pontuacao' => 0,
                    'inicio_inscricao' => $request->data_edital,
                    'homologacoes_inscricoes' => $request->data_edital,
                    'inicio_recurso_inscricao' => $request->data_edital,
                    'fim_recurso_inscricao' => $request->data_edital,
                    'homologacao_final' => $request->data_edital,
                    'inicio_proeficiencia' => $request->data_edital,
                    'fim_proeficiencia' => $request->data_edital,
                    'aprovados_primeira_fase' => $request->data_edital,
                    'inicio_recurso_primeira_fase' => $request->data_edital,
                    'fim_recurso_primeira_fase' => $request->data_edital,
                    'resultado_final_primeira_fase' => $request->data_edital,
                    'inicio_ccint' => $request->data_edital,
                    'fim_ccint' => $request->data_edital,
                    'resultado_segunda_fase' => $request->data_edital,
                    'inicio_recurso_segunda_fase' => $request->data_edital,
                    'fim_recurso_segunda_fase' => $request->data_edital,
                    'resultado_final_segunda_fase' => $request->data_edital,
                    'reuniao_esclarecimentos' => $request->data_edital,
                    'inicio_entrega_documentos' => $request->data_edital,
                    'fim_entrega_documentos' => $request->data_edital,
                    'inicio_avaliacao_documentos' => $request->data_edital,
                    'fim_avaliacao_documentos' => $request->data_edital,
                    'envio_candidaturas' => $request->data_edital,
                    'inicio_recepcao_carta' => $request->data_edital,
                    'fim_recepcao_carta' => $request->data_edital,
                    'divulgacao_resultado_terceira_fase' => $request->data_edital,
                    'inicio_aquisicoes' => $request->data_edital,
                    'inicio_mobilidade' => $request->data_edital
                ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        $candidato = Candidato::where('nome', $request->aluno)
                                ->where('matricula', $request->matricula)->first();

        if(empty($candidato)){

            try{
                $candidato = Candidato::create([
                'nome' => $request->aluno,
                'sexo' => $request->sexo,
                'matricula' => $request->matricula,
                'cpf' => '000',
                'rg' => '000',
                'orgao_expedidor' => 'ssa',
                'data_nascimento' => $request->data_edital,
                'curso' => $request->curso,
                'celular' => '000',
                'user_id' => 0,
                'email' => "teste@gmail.com",
                'foto_perfil' => "avatars/0/face.jpg",
                'cotista'     => $request->cotista
            ]);
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        $convenio = Convenios::where('universidade', $request->universidade)->first();

        $candidatura = Candidaturas::where('candidato_id', $candidato->id)
                                    ->where('ies_anfitria', $request->universidade)->first();
        if(empty($candidatura)){

            DB::beginTransaction();
            try{
                $candidatura = Candidaturas::create([
                'candidato_id' => $candidato->id,
                'edital_id' => $edital->id,
                'primeira_opcao_universidade'=> $request->universidade,
                'primeira_opcao_curso' => $request->curso,
                'primeira_opcao_pais' => $convenio->pais,
                'segunda_opcao_universidade' => $request->universidade,
                'segunda_opcao_curso' => $request->curso,
                'segunda_opcao_pais'=> $convenio->pais,
                'terceira_opcao_universidade'=> $request->universidade,
                'terceira_opcao_curso'=> $request->curso,
                'terceira_opcao_pais'=> $convenio->pais,
                'matricula'=> $request->matricula,
                'historico'=> "avatars/0/documento.pdf",
                'percentual'=> "avatars/0/documento.pdf",
                'curriculum'=> "avatars/0/documento.pdf",
                'plano_trabalho1'=> "avatars/0/documento.pdf",
                'plano_trabalho2'=> "avatars/0/documento.pdf",
                'plano_trabalho3'=> "avatars/0/documento.pdf",
                'plano_estudo1'=> "avatars/0/documento.pdf",
                'plano_estudo2'=> "avatars/0/documento.pdf",
                'plano_estudo3'=> "avatars/0/documento.pdf",
                'certificado_proficiencia1'=> 0,
                'certificado_proficiencia2'=> 0,
                'certificado_proficiencia3'=> 0,
                'status_id'=> 14,
                'carta'=> 0,
                'desempenho' => 0,
                'proficiencia_id1' => 0,
                'proficiencia_id2' => 0,
                'proficiencia_id3' => 0,
                'quarta_opcao_universidade' => $request->universidade,
                'quarta_opcao_curso' => $request->curso,
                'quarta_opcao_pais' => $convenio->pais,
                'nome_professor_carta' => "Anônimo",
                'professor_departamento_id' => 1,
                'plano_trabalho4' => 0,
                'plano_estudo4' => 0,
                'ies_anfitria' => $request->universidade,
                'finalizado' => false

            ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }
        return redirect('/estudantes/Uefs')->with('message', 'CANDIDATURA ADICIONADA COM SUCESSO!');
    }

    function updateEstudanteUefs(Request $request, $id){

        $edital = Editais::where('nome', $request->programa)
                        ->where('numero', $request->numero)->first();

        if(empty($edital)){
            DB::beginTransaction();
            try{

                $edital = Editais::create([
                    'fim_inscricao' => $request->data_edital,
                    'nome' => $request->programa,
                    'numero' => $request->numero,
                    'qtd_bolsas'=> 1,
                    'status_edital_id'=> 20,
                    'path_anexo'=> 'avatars/0/documento.pdf',
                    'maior_pontuacao' => 0,
                    'inicio_inscricao' => $request->data_edital,
                    'homologacoes_inscricoes' => $request->data_edital,
                    'inicio_recurso_inscricao' => $request->data_edital,
                    'fim_recurso_inscricao' => $request->data_edital,
                    'homologacao_final' => $request->data_edital,
                    'inicio_proeficiencia' => $request->data_edital,
                    'fim_proeficiencia' => $request->data_edital,
                    'aprovados_primeira_fase' => $request->data_edital,
                    'inicio_recurso_primeira_fase' => $request->data_edital,
                    'fim_recurso_primeira_fase' => $request->data_edital,
                    'resultado_final_primeira_fase' => $request->data_edital,
                    'inicio_ccint' => $request->data_edital,
                    'fim_ccint' => $request->data_edital,
                    'resultado_segunda_fase' => $request->data_edital,
                    'inicio_recurso_segunda_fase' => $request->data_edital,
                    'fim_recurso_segunda_fase' => $request->data_edital,
                    'resultado_final_segunda_fase' => $request->data_edital,
                    'reuniao_esclarecimentos' => $request->data_edital,
                    'inicio_entrega_documentos' => $request->data_edital,
                    'fim_entrega_documentos' => $request->data_edital,
                    'inicio_avaliacao_documentos' => $request->data_edital,
                    'fim_avaliacao_documentos' => $request->data_edital,
                    'envio_candidaturas' => $request->data_edital,
                    'inicio_recepcao_carta' => $request->data_edital,
                    'fim_recepcao_carta' => $request->data_edital,
                    'divulgacao_resultado_terceira_fase' => $request->data_edital,
                    'inicio_aquisicoes' => $request->data_edital,
                    'inicio_mobilidade' => $request->data_edital
                ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        $candidatura = Candidaturas::find($id);

        $candidato = Candidato::where('id', $candidatura->candidato_id)->first();

        try{
            $candidato->nome = $request->aluno;
            $candidato->sexo = $request->sexo;
            $candidato->matricula = $request->matricula;
            $candidato->curso = $request->curso;
            $candidato->cotista = $request->cotista;
            $candidato->save();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        try{
            $candidatura->edital_id = $edital->id;
            $candidatura->ies_anfitria = $request->universidade;
            $candidatura->save();
        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        
        return redirect('/estudantes/Uefs')->with('message', 'CANDIDATURA ATUALIZADA COM SUCESSO!');
    }
}
