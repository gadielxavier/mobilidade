<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidaturas;
use App\Cursos;
use DB, Excel, Log, PDF;
use Carbon\Carbon;



class RelatoriosController extends Controller
{
    public function index()
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

        $candidaturasEdital = Candidaturas::where('status_id', 14)
        ->with('edital')
        ->get()
        ->groupBy('edital.nome');

        $cursos = Cursos::all();

        $paises = DB::table('pais')->get();


        $data = [
            'candidaturasCurso'    => $candidaturasCurso,
            'candidaturasPais'     => $candidaturasPais,
            'candidaturasAno'      => $candidaturasAno,
            'candidaturasEdital'   => $candidaturasEdital,
            'cursos'               => $cursos,
            'paises'               => $paises
        ];

        return view('relatorios.relatorios')->with($data);
    }

    /**
     * Create a new convenio instance.
     *
     * @param  Request  $request
     * @return Response
     */
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

        return redirect('/relatorios')->with('message', 'Relatório GERADO COM SUCESSO!');
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

        //dd($tabela);

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

        return $arquivo;
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

        return $arquivo;

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

        return $arquivo;

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

        //dd($tabela);


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

        return $arquivo;
    }
}
