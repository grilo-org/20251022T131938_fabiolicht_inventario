@extends('web.layout.header')
@section('titulo', 'Acervos')	
@section('content')

<style>
    .img-card {
        width: 350px; /* Define a largura fixa para os cartões de imagem */
        height: 350px; /* Define a altura fixa para os cartões de imagem */
        overflow: hidden; /* Esconde a parte excedente da imagem */
    }
    .img-card img {
        width: 100%; /* Ajusta a imagem para cobrir a largura do cartão */
        height: 100%; /* Ajusta a imagem para cobrir a altura do cartão */
        object-fit: cover; /* Mantém a proporção da imagem enquanto cobre todo o espaço */
    }
</style>

<section data-bs-version="5.1" class="header2 lodgem5 cid-tE36ynOyqR mbr-parallax-background" id="aheader2-3b">
    <div class="align-center container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h1 class="mbr-section-title mbr-fonts-style align-center mbr-white display-2"><br><br>Acervos</h1>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="carousel slide testimonials-slider slider2 studiom4_slider2 cid-tE39RP0bbm" data-interval="false" data-bs-interval="false" id="slider2-3r">
    <div class="container-fluid align-center">
        <div class="row justify-content-center">
            <div class="carousel slide" role="listbox" data-pause="true" data-keyboard="false" data-ride="false" data-bs-ride="false" data-interval="false" data-bs-interval="false">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-bs-target="#carouselExampleIndicators" data-slide-to="0" data-bs-slide-to="0" class="active"></li>
                </ol>
                <div class="container">
                    <div class="row justify-content-center">
                        @foreach ($acervos as $acervo)
                        <div class="col-md-3 img-card mt-3">
                            <div class="img-block">
                                <div class="wrapper-img">
                                    <a href="{{ url('acervos/detalhar/' . $acervo->id) }}">
                                        <img src="{{ url($acervo->foto_frontal_acervo) }}" alt="{{$acervo->nome_acervo}}">
                                    </a>
                                    <div class="title-block">
                                        <a href="{{ url('acervos/detalhar/' . $acervo->id) }}">
                                        <h4 class="mbr-fonts-style signature mbr-bold display-4">{{$acervo->nome_acervo}}</h4>
                                        </a>
                                        <div class="card-icon">
                                            <span class="mbr-iconfont icon-arrow mobi-mbri-right mobi-mbri"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('web.layout.footer')		
@endsection
