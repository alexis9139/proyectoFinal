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
            ->paginate(3);
            // return view('categoria.index',["categorias"=>$categorias,"buscarTexto"=>$sql]);
            return $categorias;
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
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
        return Redirect::to('categoria');
    }



    public function destroy($id)
    {
        //
    }
}
