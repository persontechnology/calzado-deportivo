<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function eliminar(User $user, Role $role)
    {
        $data = array(
            'Vendedor',
            'Cliente',
            'Administrador'
        );
        
        if(in_array($role->name,$data)){
            return false;
        }else{
            return true;
        }
    }


    public function actualizarPermisos(User $user, Role $role)
    {
        
        if($role->name=='Administrador'){
            return false;
        }else{
            return true;
        }
    }
}
