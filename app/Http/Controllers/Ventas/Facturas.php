<?php

namespace App\Http\Controllers\Ventas;


use App\DataTables\Ventas\ClientesDataTable;
use App\DataTables\Ventas\FacturasDataTable;
use App\DataTables\Ventas\ProductosDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ventas\Facturas\RqGuardar;
use App\Models\Configuracion;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Producto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
class Facturas extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:G. Ventas']);
    }

    public function index(FacturasDataTable $dataTable)
    {
        return $dataTable->render('ventas.facturas.index');
    }

    public function nuevo(ClientesDataTable $udt, ProductosDataTable $pdt) 
    {

        if (request()->get('table') == 'posts') {
          return $udt->render('ventas.facturas.nuevo', compact('udt', 'pdt'));
        }
        
        $cosumidor=User::where('apellidos','Consumidor')->first();
        $ultimaFactura=Factura::latest()->first();
        $data = array(
            'udt' =>$udt ,
            'pdt'=>$pdt,
            'consumidor'=>$cosumidor,
            'ultimaFactura'=>$ultimaFactura,
            'iva'=>Configuracion::first()->iva??12
        );
        return $pdt->render('ventas.facturas.nuevo', $data);
    }


    public function guardar(RqGuardar $request)
    {
        try {
            DB::beginTransaction();
            
            $user=User::where('identificacion',$request->identificacion)->first();
            if(!$user){
                $user=new User();   
                $user->identficacion=$request->identificacion;
            }
            $user->apellidos=$request->apellidos;
            $user->nombres=$request->nombres;
            $user->direccion=$request->direccion;
            $user->telefono=$request->telefono;
            $user->save();

            $factura=new Factura();
            $factura->numero=$request->numero;
            $factura->forma_pago=$request->forma_pago;
            $factura->observacion=$request->observacion;
            $factura->iva=Configuracion::first()->iva??12;
            $factura->vendedor_id=Auth::id();
            $factura->cliente_id=$user->id;
            $factura->save();

            foreach ($request->producto as $pro) {
                $df=new FacturaDetalle();
                $df->cantidad=$request->cantidad[$pro];
                $df->descripcion=$request->detalle[$pro];
                $df->valor_unitario=$request->valor_unitario[$pro];
                $df->factura_id=$factura->id;
                $df->producto_id=$pro;
                $df->save();
                $df->producto->cantidad=$df->producto->cantidad-$request->cantidad[$pro];
                $df->producto->save();
            }

            DB::commit();
            $data = array(
                'success' => 'Factura '.$factura->numero.' creado exitosamente' ,
                'url'=>route('imprimirFactura',$factura->id),
                'titulo'=>'IMPRIMIR FACTURA '.$factura->numero,
                'ultimaFactura'=>$factura->numero
            );
            

        } catch (\Throwable $th) {   
            DB::rollback();
            $data = array(['error' => 'Ocurrio un error, porfavor vuelva intentar '.$th->getMessage() ]);
        }
        return response()->json($data);

    }


    public function imprimir(Request $request,$idFactur)
    {
        $factura=Factura::findOrFail($idFactur);
        $data = array('factura' => $factura );
        $pdf = PDF::loadView('ventas.facturas.imprimir', $data);
        return $pdf->inline($factura->numero.'.pdf');
    }


    public function ver(Request $request,$idFactur)
    {
        $factura=Factura::findOrFail($idFactur);
        $data = array('factura' => $factura );
        return view('ventas.facturas.ver',$data);
    }

    public function estado(Request $request)
    {
        $factura=Factura::findOrFail($request->id);
        try {
            if($factura->estado=='Entregado'){
                $factura->estado='Anulado';

                foreach ($factura->facturaDetalles as $df) {
                    $df->producto->cantidad=$df->producto->cantidad+$df->cantidad;
                    $df->producto->save();
                }

            }else{
                $factura->estado='Entregado';
                foreach ($factura->facturaDetalles as $df) {
                    $df->producto->cantidad=$df->producto->cantidad-$df->cantidad;
                    $df->producto->save();
                }
            }
            $factura->save();
            return response()->json(['success'=>'Factura '.$factura->estado.' exitosamente']);
        } catch (\Exception $th) {
            return response()->json(['error'=>'Ocurrio un error, porfavor vuelva intentar']);
        }
    }



    public function buscarFechaFecha(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date'
        ]);
        
        $facturas=Factura::whereDate('created_at','>=', $request->desde)
        ->whereDate('created_at','<=', $request->hasta)->get();


        $data = array(
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'facturas'=>$facturas,
            'facturas_entregadas'=>$facturas->where('estado','Entregado')->count(),
            'facturas_anulados'=>$facturas->where('estado','Anulado')->count()
        );

        
        return view('ventas.facturas.buscarFechaFecha',$data);
    }


    public function buscarCliente(Request $request)
    {
        $cli=User::where('identificacion',$request->identificacion)->first();
        if($cli){
            return response()->json($cli);
        }
        return response()->json(null);
    }

  
}
