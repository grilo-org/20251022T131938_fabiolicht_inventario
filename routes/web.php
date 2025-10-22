<?php

use App\Mail\MensagemMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Parte Publica do site


Route::get('/', 'PortalController@index')->name('portal');
Route::get('/sobre', 'PortalController@sobre')->name('sobre');
Route::get('/noticia', 'PortalController@noticias')->name('noticias');
Route::get('/educacao-patrimonial', 'PortalController@educacao')->name('educacao');
Route::get('/galeria-3d', 'PortalController@galeria3d')->name('galeria_3d');
Route::get('/tour-3d', 'PortalController@tour3d')->name('tour_3d');
Route::get('acervos', 'AcervoPublicoController@index')->name('acervo_publico');
Route::get('acervos/detalhar/{id}', 'AcervoPublicoController@detalhar');
Route::get('/acervos/obras/{acervoId}', 'AcervoPublicoController@listarObrasPorAcervo');
Route::get('/exposicao', 'PortalController@exposicao')->name('exposicao');
Route::get('/exposicao/catedral-metropolitana', 'PortalController@catedralMetropolitana')->name('exposicao-catedral-metropolitana');
Route::get('/exposicao/capacitacao-sito', 'PortalController@capacitacaoSito')->name('exposicao-capacitacao-sito');
Route::get('/exposicao/bangu', 'PortalController@bangu')->name('exposicao-bangu');
Route::get('/exposicao/terezinha', 'PortalController@terezinha')->name('exposicao-terezinha');
Route::get('/exposicao/francisco-de-paula', 'PortalController@franciscoDePaula')->name('exposicao-franciscoDePaula');
Route::get('/exposicao/igreja-rio-de-janeiro', 'PortalController@santaCruz')->name('exposicao-santaCruz');


//Busca Obras
Route::get('/busca/obras', 'BuscaObrasPublicoController@index')->name('busca_obras_publico');

Route::post('/busca/obras/form', 'BuscaObrasPublicoController@busca')->name('busca_obras_publico_form');

Route::get('/obra/publico/detalhar/{id}', 'BuscaObrasPublicoController@detalhar')->name('detalhar_obras_publico');

//Busca Obras Um campo
Route::get('/busca/obras2', 'BuscaObrasPublicoController2@index')->name('busca_obras_publico2');
Route::post('/busca/obras/form2', 'BuscaObrasPublicoController2@busca')->name('busca_obras_publico_form2');
Route::get('/obra/publico/detalhar2/{id}', 'BuscaObrasPublicoController2@detalhar')->name('detalhar_obras_publico2');


//Admin do Site
Route::get('/admin', 'LoginController@index')->name('login');

Auth::routes();

Route::get('admin/home', 'HomeController@index')->name('home');
Route::get('admin/unauthorized', 'HomeController@unauthorized')->name('unauthorized');

// Usuários
Route::get('admin/usuarios', 'UserController@index')->name('usuarios');
Route::get('admin/usuarios/criar', 'UserController@criar')->name('criar_usuario');
Route::post('admin/usuarios/adicionar', 'UserController@adicionar')->name('adicionar_usuario');

Route::get('admin/usuarios/editar/{id}', 'UserController@editar')->name('editar_usuario');
Route::post('admin/usuarios/atualizar/{id}', 'UserController@atualizar')->name('atualizar_usuario');

// Acervos
Route::get('admin/acervo', 'AcervoController@index')->name('acervo');
Route::get('admin/acervo/criar', 'AcervoController@criar')->name('criar_acervo');
Route::get('admin/acervo/detalhar/{id}', 'AcervoController@detalhar')->name('detalhar_acervo');
Route::get('admin/acervo/editar/{id}', 'AcervoController@editar')->name('editar_acervo');

Route::post('admin/acervo/adicionar', 'AcervoController@adicionar')->name('adicionar_acervo');
Route::post('admin/acervo/atualizar/{id}', 'AcervoController@atualizar')->name('atualizar_acervo');
Route::post('admin/acervo/deletar/{id}', 'AcervoController@deletar')->name('deletar_acervo');

Route::get('admin/acervo/{id}/obras', 'AcervoController@getObrasAcervo')->name('acervo_obras');

// Obras
Route::get('admin/obra', 'ObraController@index')->name('obra');
Route::get('admin/obra/criar', 'ObraController@criar')->name('criar_obra');
Route::get('admin/obra/detalhar/{id}', 'ObraController@detalhar')->name('detalhar_obra');
Route::get('admin/obra/editar/{id}', 'ObraController@editar')->name('editar_obra');

Route::post('admin/obra/adicionar', 'ObraController@adicionar')->name('adicionar_obra');
Route::post('admin/obra/atualizar/{id}', 'ObraController@atualizar')->name('atualizar_obra');
Route::post('admin/obra/deletar/{id}', 'ObraController@deletar')->name('deletar_obra');

Route::get('admin/print/obra/{id}', 'PdfController@printObra')->name('obra_pdf');

//Busca Obras
Route::get('admin/busca-obras', 'BuscaObrasController@index')->name('busca_obras');

//Redefinição de senha
Mail::to('reset@alandiniz.com.br')->send(new MensagemMail());

//notificação de cadastro
Mail::send(new MensagemMail());


//Cadastro Localização Obas
Route::post('/admin/localicao-obras/adicionar', 'LocalizacoesObrasController@adicionar')->name('adicionar_localicacao');

//Cadastro Tesauro Obas
Route::post('/admin/tesauro/adicionar', 'TesauroObrasController@adicionar')->name('adicionar_tesauro');

//Cadastro Material
Route::post('/admin//material/adicionar', 'MaterrialObrasController@adicionar')->name('adicionar_material');

//Cadastro Material
Route::post('/admin/tecnica/adicionar', 'TecnicaslObrasController@adicionar')->name('adicionar_tecnica');

//Cadastro Especificação de Obras
Route::post('/admin/especificacao-obras/adicionar', 'EspecificacaoObrasController@adicionar')->name('adicionar_especificacao_obras');

//Cadastro Especificação de  Segurança Obras
Route::post('/admin/especificacao-seguranca-obras/adicionar', 'EspecificacaoSegurancaObrasController@adicionar')->name('adicionar_especificacao_seg_obras');

//Cadastro Especificação de  Acervo
Route::post('/admin/especificacao-acervos/adicionar', 'EspecificacaoAcervosController@adicionar')->name('adicionar_especificacao_acervos');

//Lipando o cache do site
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Remoção do cache";
});

//Vídeos
Route::get('admin/videos', 'VideosController@index')->name('videos');
Route::get('admin/videos/criar', 'VideosController@videos')->name('criar_videos');
Route::post('admin/videos/criar/salvar', 'VideosController@salvar')->name('salvar_video');
Route::get('admin/videos/editar/{id}', 'VideosController@editar')->name('editar_video');
Route::post('admin/videos/editar/update/{id}', 'VideosController@update')->name('atualizar_video');
Route::post('admin/videos/delete/{id}', 'VideosController@delete')->name('deletar_video');

//Blog
Route::get('admin/blog', 'BlogController@index')->name('blog');
Route::get('admin/blog/criar', 'BlogController@criar')->name('criar_blog');
Route::post('admin/blog/criar/salvar', 'BlogController@salvar')->name('salvar_blog');
Route::get('admin/blog/editar/{id}', 'BlogController@editar')->name('editar_blog');
Route::post('admin/blog/editar/update/{id}', 'BlogController@update')->name('atualizar_blog');
Route::post('obra-publico/deletar/{id}', 'BuscaObrasPublicoController2@deletar');


// Função sair
Route::get('sair', 'TopoController@sair')->name('sair');

Route::get('/{slug}', 'ArtigoController@index')->name('materia');

Route::get('/lerpdf/{id}', 'PdfController@lerPdf')->name('ler_pdf');
