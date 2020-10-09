<table class="table table-bordered">
    <thead >
        <tr>
            <td colspan="2">
                SEÑOR/A: 
                <a href="{{ route('editarUsuario',$factura->cliente->id) }}" class="text-primary">
                    {{ Str::limit($factura->cliente->apellidos.' '.$factura->cliente->nombres,110,'..') }}
                </a>
            </td>
            
            <td colspan="2">FECHA: {{ $factura->created_at->toDateString() }}</td>
            
        </tr>
        <tr>
            <td colspan="2">R.U.C: {{ Str::limit($factura->cliente->identificacion,110,'') }}</td>            
            <td colspan="2">TELÉFONO: {{ Str::limit($factura->cliente->telefono,15,'..') }}</td>
        </tr>
        <tr>
            <td colspan="2">DIRECCIÓN: {{ Str::limit($factura->cliente->direccion,110,'..') }}</td>
            <td colspan="2">VENDEDOR: {{ Str::limit($factura->vendedor->aplelidos.' '.$factura->vendedor->nombres,15,'..') }}</td>
        </tr>
        
        <tr>
            <td colspan="4" style="border-color: transparent; border-bottom-color: blue;"></td>
        </tr>
    </thead>


    @php($total=0)
    <tbody>
        <tr>
            <th class="textoCentrado">CANTIDAD</td>
            <th class="textoCentrado">DETALLE</th>
            <th class="textoCentrado">V.UNITARIO</th>
            <th class="textoCentrado">V.TOTAL</th>
        </tr>

        @foreach ($factura->facturaDetalles as $item)

        @php($v_total=round(($item->cantidad*$item->valor_unitario),2))

                <tr>
                    <td class="textoCentrado" style="text-align: center;">{{ $item->cantidad }}</td>
                    <td class="textoCentrado">
                        <a href="{{ route('editarProducto',$item->producto->id) }}" class="text-primary">
                            {{ Str::limit($item->descripcion,110,'..') }}
                        </a>
                    </td>
                    <td class="textoCentrado" style="text-align: center;">{{ $item->valor_unitario }}</td>
                    <td class="textoCentrado" style="text-align: center;">{{ $v_total }}</td>
                </tr>


            @php($total+=$v_total)
        @endforeach
    </tbody>

    <tfoot>
        <tr >
            <td colspan="2" class="linea">
                
                    <span>
                        <strong>Forma de pago:</strong>
                        Efectivo ({{ $factura->forma_pago=='Efectivo'?'x':' ' }}) 
                        Dinero Electrónico ({{ $factura->forma_pago=='Dinero Electrónico'?'x':' ' }}) 
                        Tarjeta crédito/débito ({{ $factura->forma_pago=='Tarjeta crédito/débito'?'x':' ' }}) 
                        Cheque ({{ $factura->forma_pago=='Cheque'?'x':' ' }}) 
                        Otros ({{ $factura->forma_pago=='Otros'?'x':' ' }}) 
                    </span><hr class="new3">
                
            </td>
            <td colspan="2">

                @php($valor_total=round($total,2))
                @php($subtotal= round(($valor_total/(( $factura->iva /100)+1)),2)  )
                @php($iva=round(($valor_total-$subtotal),2))

                SUB TOTAL {{ $factura->iva }} % <strong class="float-right" id="sub_total_factura">{{ $subtotal }}</strong><br>
                SUB TOTAL 0 % <strong class="float-right">0.00</strong><br>
                DESCUENTO <strong class="float-right">0.00</strong><br>
                SUB TOTAL <strong class="float-right">0.00</strong><br>
                IVA {{ $factura->iva }} % <strong class="float-right" id="iva_factura">{{ $iva }}</strong><br>
                VALOR TOTAL <strong class="float-right" id="total_factura">{{ $valor_total }}</strong><br>
                
            </td>
        </tr>
    </tfoot>
</table>