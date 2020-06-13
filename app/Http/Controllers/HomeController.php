<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function miPerfil()
    {
        $data = array('user' => Auth::user() );
        return view('auth.miPerfil',$data);
    }

    public function actualizarMiPerfil(Request $request)
    {
        $request->validate([
            'apellidos' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'password_actual' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user=Auth::user();
        $user->apellidos=$request->apellidos;
        $user->nombres=$request->nombres;
        $user->telefono=$request->telefono;
        $user->direccion=$request->direccion;

        if($request->password){
            if(Hash::check($request->password_actual,$user->password)){
                $user->password=Hash::make($request->password);
            }else{
                $request->session()->flash('info','Contraseña actual incorrecta');
                return redirect()->route('miPerfil')->withInput();        
            }
        }

        $user->save();
        $request->session()->flash('success','Perfil actualizado exitosamente');
        return redirect()->route('miPerfil');

    }
}
