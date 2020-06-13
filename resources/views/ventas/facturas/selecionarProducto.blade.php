<div class="btn-group btn-group-sm" role="group" aria-label="...">

    <button type="button" onclick="selecionarProducto(this);" 
    data-id="{{ $pro->id }}" 
    data-detalle="{{ $pro->codigo.'-'. Str::limit($pro->nombre, 20, '...') }} color: {{ $pro->color }} talla: {{ $pro->talla }}"
    data-precio="{{ $pro->precio_venta }}"
    data-cantidad="{{ $pro->cantidad }}"
    class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Selecionar producto">
        <i class="fas fa-file-export"></i>
    </button>
</div>