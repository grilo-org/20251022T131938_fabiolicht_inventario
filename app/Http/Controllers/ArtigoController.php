<?php

namespace App\Http\Controllers;

use App\Models\Acervos;
use App\Models\Blog;
use App\Models\Obras;
use Illuminate\Http\Request;

class ArtigoController extends Controller
{
    public function index(Request $request, $slug){

        
        $artigo = Blog::select('id', 'titulo', 'descricao','slug','autor','foto','created_at','updated_at')
        ->orderBy('id', 'desc')
        ->where('slug', $slug)
        ->first();

    
        return view('web.artigo',compact('artigo'));
    }


 
}
