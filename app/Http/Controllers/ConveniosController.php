<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editais;
use App\Convenios;
use App\Proeficiencia;
use DB, Log;

class ConveniosController extends Controller
{
    public function index()
    {
      $convenios = Convenios::orderBy('id', 'desc')->paginate(10);
      $proeficiencias = Proeficiencia::all();

    	$data = [
            'proeficiencias' => $proeficiencias,
            'convenios' => $convenios
        ];

        return view('convenios.convenios')->with($data);
    }

    public function details(Request $request, $id)
    {
        $convenio = Convenios::find($id);
        $proeficiencias = Proeficiencia::all();


        $data = [
            'convenio' => $convenio,
            'proeficiencias' => $proeficiencias

        ]; 
       
          return view('convenios.detalhes')->with($data);
    }

     /**
     * Create a new convenio instance.
     *
     * @param  Request  $request
     * @return Response
     */
    protected function store(Request $request)
    {
        // Validate the request...

        $this->validate($request, [
            'universidade' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
        ]);


        DB::beginTransaction();
        try{
            $convenio = Convenios::create([
            'universidade' => $request->universidade,
            'pais' => $request->pais,
            'proeficiencia_id' => $request->proeficiencia

        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/convenios')->with('message', 'Convênio CADASTRADO COM SUCESSO!');
    }

    public function update(Request $request, $id)
    {

        $convenio = Convenios::find($id);

        try{

            $convenio->universidade =  $request->universidade;
            $convenio->pais = $request->pais;
            $convenio->proeficiencia_id = $request->proeficiencia;
            $convenio->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return redirect('/convenios/' )->with('message', 'CONVÊNIOS ATUALIZADO COM SUCESSO!');
    }
}
