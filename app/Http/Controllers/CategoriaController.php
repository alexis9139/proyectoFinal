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
        //Creamos una instancia de la clase Categoria
        $categoria = new Categoria();
        // $categoria->nombre esto significa que el objeto llama a las propiedades que estan en el modelo Categoria
        // es decir  $categoria->nombre son los campos
        // por lo tanto a cada unos de esos campos le mandamos lo que recibimos del objeto $request
        // el objeto $request lo recibimos del formulario, es de decir de name
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = 1;
        // aqui se hace el registro en el save
        $categoria->save();
        //redireccionamos a la ruta categoria que esta en web.php luego de hacer el save
        return Redirect::to('categoria');
    }




    public function update(Request $request, $id)
    {
        //
    }



    public function destroy($id)
    {
        //
    }
}
