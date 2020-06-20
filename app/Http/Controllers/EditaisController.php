<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Editais;
use App\Candidaturas;
use App\Status_Inscricao;
use App\Status_Edital;
use App\User;
use App\Avaliacao_Ccint;
use DB, Log;

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
    	$editais = Editais::orderBy('id', 'desc')->get();

    	$data = [
            'editais' => $editais
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

        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/editais');
    }

    public function details(Request $request, $id)
    {
        $edital = Editais::find($id);
        $candidaturas = Candidaturas::where('edital_id', $id)->paginate(10);
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

    public function atualizar(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();
        $status = Status_Edital::all();

        $data = [
            'edital' => $edital,
            'status' => $status
        ]; 
       
          return view('editais.atualizar')->with($data);
    }

    public function resultado(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();
        $status = Status_Edital::all();
        $avaliacoes = Avaliacao_Ccint::where('edital_id', $edital->id)
        ->orderBy('nota_final', 'desc')->get();

        $data = [
            'edital' => $edital,
            'avaliacoes' => $avaliacoes,
            'status' => $status
        ]; 
       
          return view('editais.resultado')->with($data);
    }

    public function atualizarResultado(Request $request, $id)
    {
        $edital = Editais::where('id', $id)->first();

        for ($i = 0; $i<count($request->input('avaliacoes'));  $i++) {

            $avaliacao = Avaliacao_Ccint::where('id', $request->input('avaliacoes')[$i])->first();

            $desempenho_academico = $request->input('desempenho')[$i];

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



        return redirect('/editais');

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
            $edital->fim_inscricao = $request->fim_inscricao;
            $edital->status_edital_id = $request->status;
            $edital->path_anexo = $anexo;
            $edital->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return redirect('/editais');
    }

    public function candidatura(Request $request, $id)
    {
        $candidatura =  Candidaturas::find($id);
        $status =  Status_Inscricao::all();

        $data = [
            'candidatura' => $candidatura,
            'status' => $status
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

        foreach ($request->input('candidatura') as $candidatura) {

            $avaliacao = Avaliacao_Ccint::where('candidatura_id', $candidatura)->first();
            if($avaliacao != null){

                $avaliacao->delete();
            }
            
            DB::beginTransaction();
            try{
                $avaliacaoCcint = Avaliacao_Ccint::create([
                'candidatura_id' => $candidatura,
                'avaliador_id' => $request->avaliador,
                'desempenho_academico' => 0,
                'plano_trabalho' => 0,
                'curriculum_lattes' => 0,
                'carta' => 0,
                'nota_final' => 0,
                'finalizado' => false,
                'edital' => $candidatura->edital_id,
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

        return redirect('/editais');

    }
}
