<?php

namespace App\Http\Controllers;

use App\Models\Acervos;
use App\Models\Blog;
use App\Models\Obras;
use App\Models\Videos;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(){

        
        $acervos_total = Acervos::select('id')->count('id');
        $obras_total = Obras::select('id')->count('id');
        $blogs = Blog::select('id', 'titulo', 'descricao','slug','autor','foto','created_at','updated_at')
        ->limit(3)
        ->orderBy('id', 'desc')
        ->get();

       //var_dump($acervos_total);die();

        return view('web.index',compact('acervos_total','obras_total','blogs'));
    }

    public function sobre(){


        return view('web.sobre');
    }

    public function noticias(){

        $blogs = Blog::select('id', 'titulo', 'descricao','slug','autor','foto','created_at','updated_at')
        ->orderBy('id', 'desc')
        ->get();

        return view('web.noticias',compact('blogs'));
    }

    public function educacao(){

        $videos = Videos::select('id','titulo','url','created_at')
        ->orderBy('id', 'desc')
        ->get();

        return view('web.educacao',compact('videos'));
    }

    public function galeria3d(){

    

        return view('web.galeria_3d');
    }

    public function tour3d(){

    

        return view('web.tour_3d');
    }

    public function exposicao(){

        return view('web.exposicao_etinerante');
    }

    public function catedralMetropolitana(){

        return view('web.exposicoes.catedralMetropolitana');
    }

    public function capacitacaoSito(){

        return view('web.exposicoes.capacitacaoSito');
    }

    public function bangu(){

        return view('web.exposicoes.bangu');
    }

    public function terezinha(){

        return view('web.exposicoes.terezinha');
    }

    public function franciscoDePaula(){

        return view('web.exposicoes.franciscoDePaula');
    }

    public function santaCruz(){

        return view('web.exposicoes.santaCruz');
    }

}
