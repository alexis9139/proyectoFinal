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
        //
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
