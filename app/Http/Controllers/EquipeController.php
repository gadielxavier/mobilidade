<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class EquipeController extends Controller
{
    
    /**
     * Show the application equiupe.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$equipe = User::where('privilegio', 2)->orWhere('privilegio', 3)->get(); 

    	 $data = [
            'equipe'  => $equipe
        ];
        
        
        return view('equipe.equipe')->with($data);
    }

     /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function store(Request $request)
    {
    	 $this->validate($request, [
            'email' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'privilegio' => $request['tipo_usuario'],
            'password' => bcrypt('123456'),
        ]);


        return redirect('/equipe');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        $user->delete();
        return redirect('/equipe');
    }
}
