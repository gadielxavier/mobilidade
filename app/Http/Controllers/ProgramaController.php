<?php

namespace App\Http\Controllers;

use App\Programa;
use App\Editais;
use Illuminate\Http\Request;
use DB, Log;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programas = Programa::orderBy('nome')->paginate(30);

        $data = [
            'programas' => $programas
        ];

        return view('programas.programas')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...

        $this->validate($request, [
            'nome' => 'required|string|max:255',
        ]);


        DB::beginTransaction();
        try{
            $programa = Programa::create([
            'nome' => $request->nome

        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/programas')->with('message', 'Programa CADASTRADO COM SUCESSO!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programa  $programa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $programa = Programa::find($id);

        $editais = Editais::where('nome', $programa->nome)->get();

        foreach ($editais as $edital) {

            try{
                $edital->nome = $request->nome;
                $edital->save();
            }
            catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }
        }

        try{

            $programa->nome =  $request->nome;
            $programa->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        return redirect('/programas/' )->with('message', 'Programa ATUALIZADO COM SUCESSO!');
    }
}
