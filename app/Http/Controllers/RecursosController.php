<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Recursos;
use App\Candidaturas;
use App\Resposta_Recurso;
use App\Notifications\RespostaRecursoNotification;
use App\User;
use DB, Log;

class RecursosController extends Controller
{
    public function index()
    {
    	$recursos = Recursos::where('replied', false)->orderBy('id', 'desc')->paginate(10);
        $recursosRespondidos = Recursos::where('replied', true)->orderBy('id', 'desc')->paginate(10);

    	$data = [
            'recursos' => $recursos,
            'recursosRespondidos' => $recursosRespondidos
        ];

        return view('recursos.recursos')->with($data);
    }

    public function details(Request $request, $id)
    {
        $recurso = Recursos::find($id);
        $resposta = Resposta_Recurso::where('recurso_id', $id)->first();

        $data = [
            'recurso' => $recurso,
            'resposta' => $resposta
        ]; 
       
          return view('recursos.detalhes')->with($data);
    }

    public function storeResposta(Request $request, $id)
    {
        $recurso = Recursos::find($id);

         try{

            $recurso->replied =  true;
            $recurso->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        DB::beginTransaction();
        try{

            $resposta = Resposta_Recurso::create([
            'recurso_id' => $recurso->id,
            'description' => $request->description,

        ]);
            
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }

        $candidatura =  Candidaturas::where('candidato_id', $recurso->candidato->id)->where('edital_id', $recurso->edital->id)->first();

         try{
            $candidatura->status_id = $request->status;
            $candidatura->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
        
        $recursos = Recursos::where('replied', false)->paginate(10);
        $recursosRespondidos = Recursos::where('replied', true)->paginate(10);

        $data = [
            'recursos' => $recursos,
            'recursosRespondidos' => $recursosRespondidos
        ];

        $user = User::where('id', $candidatura->candidato->user_id)->first();
        $user->notify(new RespostaRecursoNotification($recurso->id));

        return view('recursos.recursos')->with($data);
    }
}
