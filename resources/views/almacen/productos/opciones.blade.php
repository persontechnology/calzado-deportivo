
 

<a  href="{{ route('editarProducto', $pro->id) }}" data-toggle="tooltip" data-placement="top" data-title="Editar">
    <i class="fas fa-edit text-primary"></i>
</a>

<a role="button" onclick="duplicar(this);" data-url="{{ route('duplicarProducto') }}" data-id="{{ $pro->id }}" class="" data-toggle="tooltip" data-placement="top" data-title="Duplicar">
    <i class="fas fa-clone"></i>
</a>

<a role="button" onclick="eliminar(this);" data-url="{{ route('eliminarProducto',$pro->id) }}" class="" data-toggle="tooltip" data-placement="top" data-title="Eliminar">
    <i class="fas fa-trash text-danger"></i>
</a>
