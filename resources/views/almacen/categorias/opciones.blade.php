
 

<a  href="{{ route('editarCategoria', $cat->id) }}" data-toggle="tooltip" data-placement="top" data-title="Editar">
    <i class="fas fa-edit text-primary"></i>
</a>

<a role="button" onclick="eliminar(this);" data-url="{{ route('eliminarCategoria',$cat->id) }}" class="" data-toggle="tooltip" data-placement="top" data-title="Eliminar">
    <i class="fas fa-trash text-danger"></i>
</a>
