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
    	$equipe = User::where('privilegio', 2)->get(); 

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
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'privilegio' => 2,
            'password' => bcrypt($request['password']),
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
