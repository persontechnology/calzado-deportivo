<?php

namespace App\Http\Controllers\Almacen;

use App\DataTables\ProdutosDataTable;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Productos extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:G. Almacén']);
    }
    
    public function index(ProdutosDataTable $dataTable)
    {
        return $dataTable->render('almacen.productos.index');
    }

    public function nuevo()
    {
        $categorias=Categoria::orderBy('nombre','asc')->get();
        $data = array('categorias' => $categorias );
        return view('almacen.productos.nuevo',$data);
    }

    public function guardar(Request $request)
    {
        $rg_decimal="/^[0-9,]+(\.\d{0,2})?$/";
        $request->validate([
            'categoria'=>'nullable|exists:categorias,id',
            'codigo'=>'required|string|max:255',
            'nombre'=>'required|string|max:255',
            'talla'=>'required|regex:'.$rg_decimal,
            'color'=>'required|string|max:255',
            'descripcion'=>'required|string|max:255',
            'precio_compra'=>'required|regex:'.$rg_decimal,
            'precio_venta'=>'required|regex:'.$rg_decimal,
            'cantidad'=>'required|regex:'.$rg_decimal

        ]);

        $pro=new Producto();

        $pro->codigo=$request->codigo;
        $pro->nombre=$request->nombre;
        $pro->descripcion=$request->descripcion;
        $pro->precio_compra=$request->precio_compra;
        $pro->precio_venta=$request->precio_venta;
        $pro->cantidad=$request->cantidad;
        $pro->categoria_id=$request->categoria;
        $pro->talla=$request->cantidad;
        $pro->color=$request->color;
        $pro->save();

        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/productos', $request->file('foto'), $pro->id.'.'.$extension
                );
                $pro->foto=$path;
                $pro->save();
            }
        }


        $request->session()->flash('success',$pro->nombre.' ingresado exitosamente');
        return redirect()->route('productos');
    }

    public function editar($idPro)
    {
        $pro=Producto::findOrFail($idPro);
        $categorias=Categoria::orderBy('nombre','asc')->get();
        $data = array('pro' => $pro,'categorias'=>$categorias );
        return view('almacen.productos.editar',$data);
        
    }
    
    public function actualizar(Request $request)
    {
        $rg_decimal="/^[0-9,]+(\.\d{0,2})?$/";
        $request->validate([
            'id'=>'required|exists:productos,id',
            'categoria'=>'nullable|exists:categorias,id',
            'codigo'=>'required|string|max:255',
            'nombre'=>'required|string|max:255',
            'talla'=>'required|regex:'.$rg_decimal,
            'color'=>'required|string|max:255',
            'descripcion'=>'required|string|max:255',
            'precio_compra'=>'required|regex:'.$rg_decimal,
            'precio_venta'=>'required|regex:'.$rg_decimal,
            'cantidad'=>'required|regex:'.$rg_decimal
        ]);

        $pro=Producto::findOrFail($request->id);

        $pro->codigo=$request->codigo;
        $pro->nombre=$request->nombre;
        $pro->descripcion=$request->descripcion;
        $pro->precio_compra=$request->precio_compra;
        $pro->precio_venta=$request->precio_venta;
        $pro->cantidad=$request->cantidad;
        $pro->categoria_id=$request->categoria;
        $pro->talla=$request->cantidad;
        $pro->color=$request->color;
        $pro->save();

        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                Storage::delete($pro->foto);
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/productos', $request->file('foto'), $pro->id.'.'.$extension
                );
                $pro->foto=$path;
                $pro->save();
            }
        }


        $request->session()->flash('success',$pro->nombre.' actualizado exitosamente');
        return redirect()->route('productos');
    }

    public function eliminar(Request $request, $idPro)
    {
        $pro=Producto::findOrFail($idPro);
        try {
            $urlFoto=$pro->foto;
            DB::beginTransaction();
            $pro->delete();
            DB::commit();
            Storage::delete($urlFoto);
            $request->session()->flash('success','Producto eliminado');
        } catch (\Exception $th) {
            $request->session()->flash('error',$pro->nombre. ' no eliminado');
            DB::rollback();
        }
        return redirect()->route('productos');

    }
}
