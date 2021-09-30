<?php

namespace App\Http\Controllers;

use App\Programa;
use App\Documento;
use App\Editais;
use Illuminate\Http\Request;
use DB, Log;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programasIn = Programa::where('tipo', '1')->orderBy('nome')->paginate(30);
        $programasOut = Programa::where('tipo', '2')->orderBy('nome')->paginate(30);
        $documentos = Documento::paginate(30);

        $data = [
            'programasIn' => $programasIn,
            'programasOut' => $programasOut,
            'documentos' => $documentos
        ];

        return view('documentos.documentos')->with($data);
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
            $programa = Documento::create([
            'titulo' => $request->nome
        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/documentos')->with('message', 'Documento CADASTRADO COM SUCESSO!');
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
        $documento = Documento::find($id);

        if($documento->id != 1){

            try{
                $documento->titulo =  $request->nome;
                $documento->save();

            }
            catch(\Exception $e) {
                DB::rollback();
                Log::error($e);
                return $this->error($e->getMessage(), 500, $e);
            }

            return redirect('/documentos' )->with('message', 'Documento ATUALIZADO COM SUCESSO!');

        }
        else{
            return redirect('/documentos' )->with('message', 'Plano de trabalho não pode ser alterado!');
        }
    }
}
