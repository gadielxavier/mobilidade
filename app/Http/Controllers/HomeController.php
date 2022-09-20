<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editais;
use App\Candidato;
use App\Candidaturas;
use App\User;
use Auth, DB, Log;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editais = Editais::where('status_edital_id', 1)->orderBy('id', 'desc')->get();
        $candidato = Candidato::where('user_id', Auth::user()->id)->first();
        if($candidato == null){
             $candidaturas = null;

        } 
        else{
            $candidaturas = Candidaturas::where('candidato_id', $candidato->id)->get();
        }

        $data = [
            'editais'      => $editais,
            'candidato'    => $candidato,
            'candidaturas' => $candidaturas
        ];

        if (Auth::user()->privilegio == 3) {
            return redirect('/ccint');
        }
        
        return view('home')->with($data);
    }

    public function configuracoes()
    {
        $user = Auth::user();

        $data = [
            'user'      => $user
        ];

        return view('configuracoes/configuracoes')->with($data);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'email'    => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($id);


        try{

            $user->name =  $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

        }
        catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error($e->getMessage(), 500, $e);
        }


        return redirect('/home');
    }

    public function markAsRead(){

        foreach ( Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function notification(Request $request, $id){

        $notifications = Auth()->user()->unreadNotifications->where('id', $id);

        foreach ($notifications as $notification) {
            $link = $notification->data['action'];
        }

        $notifications->markAsRead();

        return redirect($link);
    }

    public function atualizarSenha($id){

        $candidatura =  Candidaturas::find($id);
        $user = User::find($candidatura->candidato->user_id);
        $user->password = bcrypt('123456');
        $user->save();

        return redirect('/home');
        
    }
}