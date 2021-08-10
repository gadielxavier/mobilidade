<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidaturas;
use App\Cursos;
use App\Programa;
use App\Convenios;
use App\Candidato;
use App\Editais;
use App\EstudantesInternacionais;
use DB, Excel, Log, PDF;
use Carbon\Carbon;



class RelatoriosController extends Controller
{
    public function in()
    {
        $estudantesAnos = EstudantesInternacionais::all()
        ->groupBy(function($val) {
            return Carbon::parse($val->inicio)->format('Y');
        });

        $estudantesAnos = $estudantesAnos->sort();

        $estudantesModalidade = EstudantesInternacionais::all()
                    ->groupBy('modalidade');

        $estudantesPais = EstudantesInternacionais::all()
                    ->groupBy('pais');

        $estudantesProgramas = EstudantesInternacionais::all()
                    ->groupBy('programa');

        $paises = DB::table('pais')->get();

        $programas = Programa::where('tipo', '1')->get();

        $data = [
            'paises'               => $paises,
            'programas'            => $programas,
            'estudantesAnos'       => $estudantesAnos,
            'estudantesModalidade' => $estudantesModalidade,
            'estudantesPais'       => $estudantesPais,
            'estudantesProgramas'  => $estudantesProgramas,
        ];

        return view('relatorios.in')->with($data);
    }

    public function out()
    {
        $candidaturasCurso = Candidaturas::where('status_id', 14)
        ->with('candidato')
        ->get()
        ->groupBy('candidato.curso');

        $candidaturasPais = Candidaturas::where('status_id', 14)
        ->with('convenio')
        ->get()
        ->groupBy('convenio.pais');

        $candidaturasAno = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->get()
        ->groupBy(function($candidatura) {
             return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
         });

        $candidaturasAno = $candidaturasAno->sort();

        $candidaturasEdital = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->get()
        ->groupBy('edital.nome');

        $cursos = Cursos::all();

        $paises = DB::table('pais')->get();

        $programas = Programa::where('tipo', '2')->get();

        $convenios = Convenios::orderBy('pais')->orderBy('universidade')->get();

        $data = [
            'candidaturasCurso'    => $candidaturasCurso,
            'candidaturasPais'     => $candidaturasPais,
            'candidaturasAno'      => $candidaturasAno,
            'candidaturasEdital'   => $candidaturasEdital,
            'cursos'               => $cursos,
            'paises'               => $paises,
            'programas'            => $programas,
            'convenios'            => $convenios
        ];

        return view('relatorios.out')->with($data);
    }


    protected function createRelatorio(Request $request)
    {
        if($request->tipo == 1){
            if($request->dados == 0)
                $arquivo = $this->createRelatorioCurso();
            else
                $arquivo = $this->createRelatorioEspecificoCurso($request->dados);
        }
        else{
            if($request->dados == 0)
                $arquivo = $this->createRelatorioPaises();
            else
                $arquivo = $this->createRelatorioEspecificoPais($request->dados);
        }

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    protected function relatorioInternacional(Request $request)
    {
        if($request->programa == 1){
            $estudantes = EstudantesInternacionais::all();
            $programa = 'Todos os Programas';
        }
        else{
            $estudantes = EstudantesInternacionais::where('programa', $request->programa)->get();
            $programa = $request->programa;
        }

        $data = [
            'estudantes'  => $estudantes,
            'programa'    => $programa
        ];

        $arquivo = Excel::create('estatistica_estudantes_internacionais', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioInternacional', $data);

            })->setTitle('Our new awesome title')->export('csv');;

        });

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    protected function createRelatorioCurso(){

        $candidaturasCurso = Candidaturas::where('status_id', 14)
        ->with('candidato')
        ->get()
        ->sortBy('candidato.curso')
        ->groupBy('candidato.curso');

        $candidaturasAno = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->get()
        ->groupBy(function($candidatura) {
             return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
         });

        $tabela = [];

        foreach ($candidaturasCurso->keys() as $key) {
            $tabela[$key] = array();
        }

        foreach ($candidaturasCurso as $key => $curso) {

            $candidaturasCursoAno = Candidaturas::where('status_id', 14)
            ->with('edital', 'candidato')
            ->whereHas('candidato', function($query) use ($key) {
                $query->where('curso', '=', $key);
            })
            ->get()
            ->groupBy(function($candidatura) {
                 return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
             });

            foreach ($candidaturasCursoAno as $chave => $ano) {

                $tabela[$key] = array_add($tabela[$key], $chave, count($ano));

            }
        }

        $data = [
            'tipo'              => 'Curso',
            'candidaturas'      => $candidaturasCurso,
            'candidaturasAno'   => $candidaturasAno,
            'tabela'            => $tabela
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioGeral', $data);

            })->setTitle('Our new awesome title')->export('csv');;

        });

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    protected function createRelatorioEspecificoCurso($id){

        $curso = Cursos::where('codigo', $id)->first();

        $candidaturas = Candidaturas::where('status_id', 14)
        ->with('candidato')
        ->get()
        ->where('candidato.curso', $curso->nome);

        $data = [
            'tipo'              => $curso->nome,
            'candidaturas'      => $candidaturas
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioEspecifico', $data);

            })->setTitle('Our new awesome title')->export('csv');;

        });

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');

    }

    protected function createRelatorioEspecificoPais($id){

        $pais = DB::table('pais')->where('pais_id', $id)->first();

        $candidaturas = Candidaturas::where('status_id', 14)
        ->with('convenio')
        ->get()
        ->where('convenio.pais', $pais->pais_nome);

        $data = [
            'tipo'              => $pais->pais_nome,
            'candidaturas'      => $candidaturas
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioEspecifico', $data);

            })->setTitle('Our new awesome title')->export('csv');;

        });

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');

    }

    protected function createRelatorioPaises(){

        $candidaturasPais = Candidaturas::where('status_id', 14)
        ->with('convenio')
        ->get()
        ->sortBy('convenio.pais')
        ->groupBy('convenio.pais');

        $candidaturasAno = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->get()
        ->groupBy(function($candidatura) {
             return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
         });

        $tabela = [];

        foreach ($candidaturasPais->keys() as $key) {
            $tabela[$key] = array();
        }

        foreach ($candidaturasPais as $key => $pais) {

            $candidaturasPaisAno = Candidaturas::where('status_id', 14)
            ->with('edital', 'convenio')
            ->whereHas('convenio', function($query) use ($key) {
                $query->where('pais', '=', $key);
            })
            ->get()
            ->groupBy(function($candidatura) {
                 return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
             });

            foreach ($candidaturasPaisAno as $chave => $ano) {

                $tabela[$key] = array_add($tabela[$key], $chave, count($ano));

            }
        }

        $data = [
            'tipo'              => 'País',
            'candidaturas'      => $candidaturasPais,
            'candidaturasAno'   => $candidaturasAno,
            'tabela'            => $tabela
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioGeral', $data);

            })->setTitle('Our new awesome title')->export('csv');;

        });

        return redirect('/relatorios/out')->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    function candidatura(Request $request){

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
                'foto_perfil' => "avatars/0/face.jpg"
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
                'primeira_opcao_pais' => $convenio->universidade,
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
        return redirect('/relatorios/out')->with('message', 'CANDIDATURA ADICIONADA COM SUCESSO!');
    }

    function estudanteInternacional(Request $request){

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
                    'final' => $request->final
                ]);
                
                DB::commit();
            }
             catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        return redirect('/relatorios/in')->with('message', 'ESTUDANTE ADICIONADO COM SUCESSO!');

    }
}
