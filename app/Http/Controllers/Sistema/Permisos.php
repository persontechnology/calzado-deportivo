<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permisos extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrador','auth']);
    }

    public function index($idRol)
    {
        $rol=Role::findOrFail($idRol);
        $permisos=Permission::all();
        return view('sistema.permisos.index',['rol'=>$rol,'permisos'=>$permisos]);
    }

    public function sincronizar(Request $request)
    {
       $request->validate([
            "permisos"    => "nullable|array",
            "permisos.*"  => "nullable|exists:permissions,id",
            'rol'=>'required|exists:roles,id',
        ]);
        
        $rol=Role::findOrFail($request->rol);
        $rol->syncPermissions($request->permisos);
        $request->session()->flash('success','Permisos actualizados');
        return redirect()->route('roles');
    }
}
