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
        $estudantesAnos = EstudantesInternacionais::orderBy('inicio')
        ->get()
        ->groupBy(function($val) {
            return Carbon::parse($val->inicio)->format('Y');
        });

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

        $candidaturasCurso = $candidaturasCurso->sort();

        $candidaturasPais = Candidaturas::where('status_id', 14)
        ->with('convenio')
        ->get()
        ->groupBy('convenio.pais');

        $candidaturasPais =  $candidaturasPais->sort();

        $candidaturasAno = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->join('editais', 'editais.id', '=', 'candidaturas.edital_id')
        ->orderBy('editais.inicio_mobilidade')
        ->get()
        ->groupBy(function($candidatura) {
             return Carbon::parse($candidatura->edital->inicio_mobilidade)->format('Y');
         });

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
                $this->createRelatorioCurso();
            else
                $this->createRelatorioEspecificoCurso($request->dados);
        }
        else{
            if($request->dados == 0)
                $this->createRelatorioPaises();
            else
                $this->createRelatorioEspecificoPais($request->dados);
        }

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    protected function relatorioInternacional(Request $request)
    {
        if($request->programa == 1){
            $estudantes = EstudantesInternacionais::
            orderBy("nome")->get();
            $programa = 'Todos os Programas';
        }
        else{
            $estudantes = EstudantesInternacionais::where('programa', $request->programa)->orderBy("nome")->get();
            $programa = $request->programa;
        }

        $data = [
            'estudantes'  => $estudantes,
            'programa'    => $programa
        ];

        $arquivo = Excel::create('estatistica_estudantes_internacionais', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioInternacional', $data);

            })->setTitle('estatistica_estudantes_internacionais')->export('xlsx');

        });

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');
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

            })->setTitle('estatistica_intercambistas')->export('xlsx');

        });

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');
    }

    protected function createRelatorioEspecificoCurso($id){

        $curso = Cursos::where('codigo', $id)->first();

        $candidaturas = Candidaturas::where('status_id', 14)
        ->select('candidaturas.*')
        ->join('candidatos', 'candidatos.id', '=', 'candidaturas.candidato_id')
        ->orderBy('candidatos.nome')
        ->get()
        ->where('candidato.curso', $curso->nome);

        $data = [
            'tipo'              => $curso->nome,
            'candidaturas'      => $candidaturas
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioEspecifico', $data);

            })->setTitle('estatistica_intercambistas')->export('xlsx');

        });

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');

    }

    protected function createRelatorioEspecificoPais($id){

        $pais = DB::table('pais')->where('pais_id', $id)->first();

        $candidaturas = Candidaturas::where('status_id', 14)
        ->with('convenio')
        ->select('candidaturas.*')
        ->join('candidatos', 'candidatos.id', '=', 'candidaturas.candidato_id')
        ->orderBy('candidatos.nome')
        ->get()
        ->where('convenio.pais', $pais->pais_nome);

        $data = [
            'tipo'              => $pais->pais_nome,
            'candidaturas'      => $candidaturas
        ];

        $arquivo = Excel::create('estatistica_intercambistas', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('relatorios.relatorioEspecifico', $data);

            })->setTitle('estatistica_intercambistas')->export('xlsx');

        });

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');

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

            })->setTitle('estatistica_intercambistas')->export('xlsx');

        });

        return back()->with('message', 'Relatório GERADO COM SUCESSO!');
    }
}
