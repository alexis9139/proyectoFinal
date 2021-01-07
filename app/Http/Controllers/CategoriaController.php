<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\Redirect;
use DB;
class CategoriaController extends Controller
{

    public function index(Request $request)
    {
        //
        if($request){
            $sql = trim($request->get('buscarTexto'));
            $categorias = DB::table('categorias')->where('nombre','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(5);
            return view('categoria.index',["categorias"=>$categorias,"buscarTexto"=>$sql]);
            // return $categorias;
        }
    }



    public function store(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
        return Redirect::to('categoria');
    }




    public function update(Request $request)
    {
        //se cambio y se puso id_categoria que esto viene del formulario
        $categoria = Categoria::findOrFail($request->id_categoria);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
        return Redirect::to('categoria');
    }



    public function destroy(Request $request)//aqui le agregamos el request
    {
        //id_categoria viene desde el formulario
        $categoria = Categoria::findOrFail($request->id_categoria);//toma el id para editar
        if($categoria->condicion == '1'){//si esta activo
            $categoria->condicion = '0';
            $categoria->save();
            return Redirect::to('categoria');
        }else{
            $categoria->condicion = '1';
            $categoria->save();
            return Redirect::to('categoria');
        }
    }
}
