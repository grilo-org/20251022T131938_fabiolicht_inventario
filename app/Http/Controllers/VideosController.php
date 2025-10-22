<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VideosController extends Controller
{

    public function index()
    {
        $videos = Videos::select('id','titulo','url','created_at')->get();
        
      


    return view('admin.videos', compact('videos'));
}


    public function videos(Request $request)
    {
    
        return view('admin.criar_videos');
    }


    public function salvar(Request $request)
    {

        $hoje = date("Y-m-d H:i:s");
        $user = $user = Auth::user()->name;

        $videos = new Videos();
        $videos->titulo = $request->titulo_video;
        $videos->url = $request->url_video;
        $videos->user_cadastro = $user;
        $videos->created_at = $hoje;
        $videos->updated_at = $hoje;
        $videos->save();

        Alert::success('Vídeo Salvo', 'vídeo salvo com sucesso!');
        return back();
        
    }

    public function editar(Request $request){

        $videos = Videos::find($request->id);
        return view('admin.editar_videos', compact('videos'));
        

    }

    public function update(Request $request){

        $user = $user = Auth::user()->name;
        $hoje = date("Y-m-d H:i:s");
        $tiutlo = $request->edit_titulo_video;
        $url = $request->edit_url_video;;
        $videos = Videos::find($request->id);
        $videos->user_cadastro = $user;
        $videos->titulo = $tiutlo;
        $videos->url = $url;
        $videos->updated_at = $hoje;

       // print_r($videos);die;

        $videos->save();

        Alert::success('Atualizado', 'vídeo atualizado com sucesso!');
        return back();

        return view('admin.editar_videos', compact('videos'));
        

    }

    public function delete(Request $request){


        $videos = Videos::find($request->id);
     
        $videos->delete();
                    
                    if ($videos) {
                        // Retorne sucesso
                        return response()->json(['status' => 'success', 'msg' => 'Vídeo Deletado.']);
                    } else { // caso contrário
                        // Retorne falha
                        return response()->json(['status' => 'error', 'msg' => 'Ops.. Não conseguimos deletar a obra.']);
                    }

    }

}
