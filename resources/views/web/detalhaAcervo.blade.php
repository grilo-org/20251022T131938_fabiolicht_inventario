@extends('web.layout.app_acervo')
@section('acervo')

<section data-bs-version="5.1" class="header2 lodgem5 cid-txalr01ybc mbr-parallax-background" id="aheader2-2a">
      
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(83, 16, 16);"></div>

    <div class="align-center container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h1 class="mbr-section-title mbr-fonts-style align-center mbr-white display-2"><br><br>{{$acervo->nome_acervo}}</h1>
                
                
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="article4 cid-txalr0JzHr" id="article04-2b">

       
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(83, 16, 16);"></div>

    <div class="container">
        <div class="row justify-content-center">
            

            <div class="col-12 col-lg-8 col-md-12">
                <div class="text-wrapper align-left">
                    
                    <img class="w-100 pb-2" src="{{url($acervo->foto_frontal_acervo)}}" alt="Mobirise Website Builder">
                     
                    
                    <p class="mbr-text mt-4 mbr-fonts-style display-7">{{$acervo->descricao_fachada_planta_acervo}}</p>
                    
                </div>
                <div class="text-center">
                    <a class="btn btn-primary display-7 mb-3" href="{{ url('/acervos/obras/' . $acervo->id) }}">Obras deste Acervo</a>
                </div>
            </div>
              
            
        </div>
    </div>
</section>
@endsection





