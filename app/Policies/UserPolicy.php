<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function actualizar(User $user, User $model)
    {
        if($user->id==$model->id){
            return false;
        }

        if($model->hasRole('Administrador')){
            return false;
        }

        if($model->apellidos=='Consumidor'){
            return false;
        }

        return true;
    }

    public function eliminar(User $user, User $model)
    {
        if($user->id==$model->id){
            return false;
        }

        if($model->hasRole('Administrador')){
            return false;
        }

        if($model->apellidos=='Consumidor'){
            return false;
        }

        return true;
    }

    public function asignarRoles(User $user,User $model)
    {
        if($user->id==$model->id){
            return false;
        }

        if($model->hasRole('Administrador')){
            return false;
        }

        if($model->apellidos=='Consumidor'){
            return false;
        }

        return true;
    }

}
