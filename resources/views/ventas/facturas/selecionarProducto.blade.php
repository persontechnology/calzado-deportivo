<div class="btn-group btn-group-sm" role="group" aria-label="...">

    @php
        $nombrepro=($pro->categoria->nombre??'').' '.$pro->codigo.' '.Str::limit($pro->nombre, 20, '...').' '.$pro->color.' '.$pro->talla;
    @endphp
    <button type="button" onclick="selecionarProducto(this);" 
    data-id="{{ $pro->id }}" 
    data-detalle="{{ Str::limit($nombrepro, 110, '...') }}"
    data-precio="{{ $pro->precio_venta }}"
    data-cantidad="{{ $pro->cantidad }}"
    class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Selecionar producto">
        <i class="fas fa-file-export"></i>
    </button>
</div>