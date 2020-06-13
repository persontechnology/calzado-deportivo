
@can('asignarRoles', $user)
    
    <a  href="{{ route('asignarRolUsuario', $user->id) }}"  data-toggle="tooltip" data-placement="top" data-title="Roles">
        <i class="fas fa-user-tag text-dark"></i>
    </a>
    
@endcan

@can('actualizar', $user)
    <a  href="{{ route('editarUsuario', $user->id) }}" data-toggle="tooltip" data-placement="top" data-title="Editar">
        <i class="fas fa-edit text-primary"></i>
    </a>
@endcan
    

@can('eliminar', $user)
        
    <a role="button" onclick="eliminar(this);" data-url="{{ route('eliminarUsuario',$user->id) }}" class="" data-toggle="tooltip" data-placement="top" data-title="Eliminar">
        <i class="fas fa-trash text-danger"></i>
    </a>

@endcan