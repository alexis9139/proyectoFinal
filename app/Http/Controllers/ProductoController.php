<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;//para subir imagenes
use DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if($request){
            $sql = trim($request->get('buscarTexto'));
            $productos=DB::table('productos as p')
            ->join('categorias as c','p.idcategoria','=','c.id')//esta relacion debe cumplirse
            ->select('p.id','p.idcategoria','p.nombre','p.precio_venta','p.codigo','p.stock','p.condicion','c.nombre as categoria')
            ->where('p.nombre','LIKE','%'.$sql.'%')
            ->orwhere('p.codigo','LIKE','%'.$sql.'%')
            ->orderBy('p.id','desc')
            ->paginate(3);

            //como tendremos ventana modal tendremos que listar esas categorias en esa ventana
            $categorias=DB::table('categorias')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get();//solo filtramos los activos
            //creamos una carpeta producto dentro de view y adentro un index
            return view('producto.index',["productos"=>$productos,"categorias"=>$categorias,"buscarTexto"=>$sql]);
            // return $productos;

        }
    }



    public function store(Request $request)
    {
        $producto = new Producto();//instancia del modelo Producto
        $producto->idcategoria = $request->id;//id es input del name
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';
        $producto->save();
        return Redirect::to('producto');
    }




    public function update(Request $request)
    {
        //se cambio y se puso id_categoria que esto viene del formulario
        $producto = Producto::findOrFail($request->id_producto);//campo oculto
        $producto->idcategoria = $request->id;//id es input del name
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';
        $producto->save();
        return Redirect::to('producto');
    }



    public function destroy(Request $request)//aqui le agregamos el request
    {
        //id_categoria viene desde el formulario
        $producto = Producto::findOrFail($request->id_producto);//toma el id para editar
        if($producto->condicion == '1'){//si esta activo
            $producto->condicion = '0';
            $producto->save();
            return Redirect::to('producto');
        }else{
            $producto->condicion = '1';
            $producto->save();
            return Redirect::to('producto');
        }
    }
}
