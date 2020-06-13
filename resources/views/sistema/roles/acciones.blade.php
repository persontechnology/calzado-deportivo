
    
    <a href="{{ route('permisos',$rol->id) }}" role="button" type="button" class="btn btn-info btn-sm"  data-toggle="tooltip" data-placement="top" title="Permisos de {{ $rol->name }}">
        <i class="fas fa-key"></i>
    </a>
    

    @can('eliminar', $rol)
        <button onclick="eliminar(this);" data-url="{{ route('eliminarRol',$rol->id) }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" data-title="Eliminar {{ $rol->name }}">
            <i class="fas fa-trash-alt"></i>
        </button>            
    @endcan

