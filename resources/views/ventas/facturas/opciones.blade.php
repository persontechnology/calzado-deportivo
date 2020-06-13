<a role="button" onclick="imprimirFactura(this);" class="ml-1" data-url="{{ route('imprimirFactura',$fac->id) }}" data-toggle="tooltip" data-placement="top" data-title="IMPRIMIR FACTURA {{ $fac->numero }}">
    <i class="fas fa-print"></i>
</a>
<a  href="{{ route('verFactura', $fac->id) }}" data-toggle="tooltip" data-placement="top" data-title="Ver factura {{ $fac->numero }}">
    <i class="fas fa-eye text-primary"></i>
</a>

