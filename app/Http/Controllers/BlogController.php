<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    public function index(){

        $blogs = Blog::select('id', 'titulo', 'descricao','slug','autor','foto','created_at','updated_at')->get();

       // print_r($blogs);die;

        return view('admin.blog', compact('blogs'));

    }

    public function criar(Request $request){

        return view('admin.criar_blog');

    }

    public function salvar(Request $request){

        $hoje = date("Y-m-d H:i:s");
        $user = $user = Auth::user()->name;

        $blog = new Blog();
        $blog->titulo = $request->titulo_blog;
        $slug = Str::slug($request->titulo_blog);
        $blog->descricao = $request->descricao_blog;
        $blog->slug = $slug;
        $blog->autor = $user;
        $blog->created_at = $hoje;
        $blog->updated_at = $hoje;

        //print_r($blog);die();

         /* Parametrização do caminho onde as imagens ficam. */
        // Nome do primeiro folder
        $preBasePath =  'imagem';
        // Nome do segundo folder
        $basePath =  $preBasePath . '/blog';

        // Se o primeiro folder não existir
        if (! Storage::exists($preBasePath)) {
            // Ele será criado
            Storage::makeDirectory(public_path($preBasePath, 0755, true));
            // E o subfolder também (se o pré não existe, seus filhos também não existem)
            Storage::makeDirectory(public_path($basePath,0755, true));
        }else if (!is_dir($basePath)) {
            // Se não existir, cria ele
            mkdir(public_path($basePath));
        }

        /* Tratamento de dados para quando o folder de imagem do id a ser inserido já existe (não deve ser executado nunca, mas por precaução...) */
        // Parametrização do nome da pasta onde as imagens vão ficar
        $imagemaobra =  $basePath . '/' . $slug;
        if (is_dir($imagemaobra)) {
            // Deleta tudo dentro dela
            array_map('unlink', glob(public_path($imagemaobra) . "/*.*"));
            // Remoção e recriação comentadas, mas deixadas aqui pra caso de algum problema já ter uma sugestão de solução
            //rmdir(public_path($imagemaobra));
            //mkdir(public_path($imagemaobra));
        } else {
            // Já que ela não existe, cria
            mkdir(public_path($imagemaobra));
        }

          // Se houver foto frontal
          if ($request->file('foto_blog')) {
            // Seta o nome da imagem como frontal
            $imageName = "$slug.webp";
            // Cria um objeto de imagem com a imagem fornecida e marca a orientação
            $img = Image::make($request->foto_blog)->orientate();
            // Redimensiona pra 450px x auto mantendo a proporção
            $img->resize(450, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            // Salva a imagem com a codificação webp e dpi de 90
            $img->save(public_path($imagemaobra) . '/' . $imageName)->encode('webp', 90);
            $imgfile = fopen(public_path($imagemaobra) . '/' . $imageName, 'r');
            $data = fread($imgfile, filesize(public_path($imagemaobra) . '/' . $imageName));
            $md5 = md5($data); 
            fclose($imgfile);
            
            // Seta a coluna foto_frontal_obra como o caminho de onde a imagem está salva
            $blog->foto = $imagemaobra . '/' . $imageName.'?x=' . $md5;
        }

        $blog->save();
        
        Alert::success('Notícia', 'Notícia salva com sucesso!');
        return back();

    }

    public function editar(Request $request){
        $blog = Blog::find($request->id);
        return view('admin.editar_blog', compact('blog'));

    }

    public function update(Request $request){

        
        $user = $user = Auth::user()->name;
        $hoje = date("Y-m-d H:i:s");
        $blog = Blog::find($request->id);
        $slug = $blog->slug;
        $blog->titulo = $request->edit_titulo_blog;
        $blog->descricao = $request->edit_descricao_blog;
        $blog->autor = $user;
        $blog->created_at = $hoje;
        $blog->updated_at = $hoje;

       // print_r($videos);die;

       $preBasePath =  'imagem';
       // Nome do segundo folder
       $basePath =  $preBasePath . '/blog';

       // Se o primeiro folder não existir
       if (! Storage::exists($preBasePath)) {
           // Ele será criado
           Storage::makeDirectory(public_path($preBasePath, 0755, true));
           // E o subfolder também (se o pré não existe, seus filhos também não existem)
           Storage::makeDirectory(public_path($basePath,0755, true));
       }else if (!is_dir($basePath)) {
           // Se não existir, cria ele
           mkdir(public_path($basePath));
       }

       /* Tratamento de dados para quando o folder de imagem do id a ser inserido já existe (não deve ser executado nunca, mas por precaução...) */
       // Parametrização do nome da pasta onde as imagens vão ficar
       $imagemaobra =  $basePath . '/' . $blog->slug;
       if (is_dir($imagemaobra)) {
           // Deleta tudo dentro dela
           array_map('unlink', glob(public_path($imagemaobra) . "/*.*"));
           // Remoção e recriação comentadas, mas deixadas aqui pra caso de algum problema já ter uma sugestão de solução
           //rmdir(public_path($imagemaobra));
           //mkdir(public_path($imagemaobra));
       } else {
        if (!is_dir(public_path($imagemaobra))) {
            mkdir(public_path($imagemaobra));
        }
       }

         // Se houver foto frontal
         if ($request->file('foto_blog')) {
           // Seta o nome da imagem como frontal
           $imageName = "$slug.webp";
           // Cria um objeto de imagem com a imagem fornecida e marca a orientação
           $img = Image::make($request->foto_blog)->orientate();
           // Redimensiona pra 450px x auto mantendo a proporção
           $img->resize(450, null, function ($constraint) {
               $constraint->aspectRatio();
           });
           // Salva a imagem com a codificação webp e dpi de 90
           $img->save(public_path($imagemaobra) . '/' . $imageName)->encode('webp', 90);
           $imgfile = fopen(public_path($imagemaobra) . '/' . $imageName, 'r');
           $data = fread($imgfile, filesize(public_path($imagemaobra) . '/' . $imageName));
           $md5 = md5($data); 
           fclose($imgfile);
           
           // Seta a coluna foto_frontal_obra como o caminho de onde a imagem está salva
           $blog->foto = $imagemaobra . '/' . $imageName.'?x=' . $md5;
       }

       //print_r($blog);die();

        $blog->save();

        Alert::success('Atualizado', 'Notícia atualizado com sucesso!');
        return back();

        return view('admin.editar_blog', compact('blog'));

    }
}
