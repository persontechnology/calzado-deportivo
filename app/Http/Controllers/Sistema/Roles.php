<?php

namespace App\Http\Controllers\Sistema;

use App\DataTables\Sistema\RolesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class Roles extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrador','auth']);
    }

    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('sistema.roles.index');
    }

    public function guardar(Request $request)
    {
        $validatedData = $request->validate([
            'rol' => 'required|unique:roles,name|max:255',
        ]);
        Role::create(['name' => $request->rol]);
        $request->session()->flash('success','Rol ingresado');
        return redirect()->route('roles');
    }

    public function eliminar( Request $request, $idRol)
    {
        try {
            
            $rol=Role::findOrFail($idRol);
            if($rol->users->count()>0){
                $request->session()->flash('info','No se puede eliminar rol, ya que existe usuarios asignados');
            }else{
                $this->authorize('eliminar', $rol);    
                $rol->delete();
                $request->session()->flash('success','Rol eliminado');
            }
        } catch (\Exception $th) {
            $request->session()->flash('error','No se puede eliminar rol');
        }
        return redirect()->route('roles');
    }
}
 