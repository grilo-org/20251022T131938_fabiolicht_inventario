@extends('web.layout.app_blog')
@section('artigo')

<section data-bs-version="5.1" class="header2 lodgem5 cid-txalr01ybc mbr-parallax-background" id="aheader2-2a">

    
        
    
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(83, 16, 16);"></div>

    <div class="align-center container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h1 class="mbr-section-title mbr-fonts-style align-center mbr-white display-2"><br><br>{{$artigo->titulo}}</h1>
                
                
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
                    
                    <img class="w-100 pb-2" src="{{$artigo->foto}}" alt="Mobirise Website Builder">
                     
                    
                    <p class="mbr-text mt-4 mbr-fonts-style display-7">{{$artigo->descricao}}</p>
                    
                </div>
            </div>
              
            
        </div>
    </div>
</section>
@endsection





