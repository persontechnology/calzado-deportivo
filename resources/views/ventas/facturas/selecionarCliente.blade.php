<button type="button" onclick="selecionarCliente(this);" 
data-id="{{ $clie->id }}" 
data-apellidos="{{ $clie->apellidos }}"
data-nombres="{{ $clie->nombres }}"
data-identificacion="{{ $clie->identificacion }}"
data-telefono="{{ $clie->telefono }}"
data-direccion="{{ $clie->direccion }}"
 class="btn btn-elegant btn-sm" data-toggle="tooltip" data-placement="top" title="Selecionar cliente">
    <i class="fas fa-file-export fa-2x"></i>
</button>