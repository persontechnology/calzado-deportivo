<?php

namespace App\Http\Controllers;

use App\DataTables\UsuariosDataTable;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Usuarios extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:G. Usuarios']);
    }

    public function index(UsuariosDataTable $dataTable)
    {
        return $dataTable->render('usuarios.index');
    }

    public function nuevo()
    {
        return view('usuarios.nuevo');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|unique:users|max:255',
            'apellidos' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
        ]);
        $user=new User();
        $user->identificacion=$request->identificacion;
        $user->apellidos=$request->apellidos;
        $user->nombres=$request->nombres;
        $user->telefono=$request->telefono;
        $user->direccion=$request->direccion;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $request->session()->flash('success',$user->apellidos.' '.$user->nombres.', ingresado exitosamente');
        return redirect()->route('usuarios');
    }
    public function editar($idUser)
    {
        $user=User::findOrFail($idUser);
        $this->authorize('actualizar', $user);
        $data = array('user' => $user );
        return view('usuarios.editar',$data);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id'=>'required|exists:users,id',
            'identificacion' => 'required|max:255|unique:users,identificacion,'.$request->id,
            'apellidos' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$request->id,
            'password' => 'nullable|string|min:8',
        ]);
        $user=User::findOrFail($request->id);
        $this->authorize('actualizar', $user);
        $user->identificacion=$request->identificacion;
        $user->apellidos=$request->apellidos;
        $user->nombres=$request->nombres;
        $user->telefono=$request->telefono;
        $user->direccion=$request->direccion;
        
        if($request->email){
            $user->email=$request->email;
        }
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        
        $user->save();
        $request->session()->flash('success',$user->apellidos.' '.$user->nombres.', actualizado exitosamente');
        return redirect()->route('usuarios');
    }

    // A:deivid
    // D: eliminar usuario
    public function eliminar(Request $request,$idUser)
    {
        $user=User::findOrFail($idUser);
        $this->authorize('eliminar', $user);
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            $request->session()->flash('success','Usuario eliminado exitosamente');
        } catch (\Exception $th) {
            DB::rollback();
            $request->session()->flash('error',$user->apellidos.' '.$user->nombres.', no se puede eliminar');
        }

        return redirect()->route('usuarios');
    }

    public function asignarRoles($idUser)
    {
        $user=User::findOrFail($idUser);
        $this->authorize('asignarRoles', $user);
        $data = array('user' => $user,'roles'=>Role::where('name','!=','Administrador')->get());
        return view('usuarios.roles',$data);
    }

    public function actualizarRoles(Request $request)
    {

        $request->validate([
            "roles"    => "nullable|array",
            "roles.*"  => "nullable|exists:roles,id",
        ]);
    
        $user=User::findOrFail($request->id);
        $this->authorize('asignarRoles', $user);
        $user->syncRoles($request->roles);
        $request->session()->flash('success','Roles actualizados');
        return redirect()->route('usuarios');
    }
    
}
