<?php

namespace App\Http\Controllers;

use App\Candidato;
use App\Cursos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Auth, DB, Log;

class CandidatoController extends Controller
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
    	$cursos = Cursos::all(); 
    	$candidato = Candidato::where('user_id', Auth::user()->id)->first();

    	$data = [
            'cursos' => $cursos,
            'candidato' => $candidato
        ];	

        return view('candidato.candidato')->with($data);
    }

    /**
     * Create a new candidato instance.
     *
     * @param  Request  $request
     * @return Response
     */
    protected function store(Request $request)
    {
        // Validate the request...

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try{
            $candidato = Candidato::create([
            'nome' => $request->name,
            'sexo' => $request->sexo,
            'matricula' => $request->matricula,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'orgao_expedidor' => $request->emissor,
            'data_nascimento' => $request->data,
            'curso' => $request->curso,
            'celular' => $request->phone,
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'foto_perfil' => $request->foto_perfil
        ]);
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/home');

    }

    protected function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        DB::beginTransaction();


        $candidato = Candidato::where('user_id', Auth::user()->id)->first();


        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()){


            $avatar = $request->file('foto_perfil');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            $relPath = 'avatars/'.$candidato->user_id;
            if (!file_exists(public_path($relPath))) {
                mkdir(public_path($relPath), 666, true);
            }

            Image::make($avatar)->resize(300, 300)->save(public_path('avatars/'.$candidato->user_id.'/'.$filename));
             $foto_perfil = 'avatars/'.$candidato->user_id.'/'.$filename;
        }else{
             $foto_perfil =  $candidato->foto_perfil;
        }

        try{
            $candidato->update([
	            'nome' => $request->name,
	            'sexo' => $request->sexo,
	            'matricula' => $request->matricula,
	            'cpf' => $request->cpf,
	            'rg' => $request->rg,
	            'orgao_expedidor' => $request->emissor,
	            'data_nascimento' => $request->data,
	            'curso' => $request->curso,
	            'celular' => $request->phone,
                'foto_perfil' => $foto_perfil

	        ]);
            DB::commit();
        }
         catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }
          return redirect('/home');
    }
}
