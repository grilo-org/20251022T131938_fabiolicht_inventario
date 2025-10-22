@extends('web.layout.header')
@section('titulo', 'Home')	
@section('content')
    

<style>
    .arq-rio-text {
        font-family: 'Footlight MT Light', sans-serif;
        color: white;
        font-size: 50px;
       
    }

    .inventario-text {
        font-family: 'Galgony', sans-serif;
        color: white;
        font-size: 35px;
    }

    @media (max-width: 768px) {
        .image-wrapper {
            margin-top: 70px;
        }
    }
</style>
<section data-bs-version="5.1" class="header2 boldm5 cid-tyuoNN0A5J mbr-fullscreen" id="header2-32">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-wrapper">
                    <div class="image-wrapper">
                        <span class="inventario-text">inventário</span> <br> <span class="arq-rio-text">ARQ RIO</span>
                    </div>

                    <p class="mbr-text mbr-fonts-style display-7"><br>Inventário dos bens culturais da
                        Arquidiocese <br>de São Sebastião do Rio de Janeiro</p>
                    <div class="mbr-section-btn"><a class="btn btn-primary display-7" href="{{route('sobre')}}">Saiba
                            mais</a></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="features2 modernm4_features2 cid-tx4kWsUHSQ" id="features2-e">
    
    

    <div class="mbr-overlay" style="opacity: 0; background-color: rgb(19, 23, 31);">
    </div>
    
    
    <div class="container">
        <div class="row align-items-center">
            <div class="title__block col-lg-5">
                
                <h3 class="mbr-section-title mbr-fonts-style display-2"><br><br><br><br><br><br>O sistema</h3>
                <p class="mbr-text mbr-fonts-style display-4">O Inventário ArqRio é armazenado num banco de dados virtual, cuja consulta está disponivel pra toda a população. Este acesso público visa democratizar o acesso e a fruição do patrimônio cultural brasileiro</p>

               {{--}} <div class="mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="{{route('busca_obras_publico2')}}">Buscar obras</a></div>{{--}}
            </div>
            <div class="col-lg-7">
                <div class="row wrap">
                    <div class="col-md-6">
                        <div class="card__block">
                            <div class="icon__block">
                                <span class="mbr-iconfont mbr-iconfont-1 mbri-download"></span>
                            </div>
                            <h4 class="card__title mbr-medium mbr-fonts-style display-5">INVENTÁRIO DIGITAL</h4>
                            <p class="card__text mbr-fonts-style display-4">Faça buscas cruzadas por acervos, materiais, técnicas, datação, etc</p>
                            
                        </div>
                        <div class="card__block">
                            <div class="icon__block">
                                <span class="mbr-iconfont mbr-iconfont-1 mbri-globe"></span>
                            </div>
                            <h4 class="card__title mbr-medium mbr-fonts-style display-5">TOUR VIRTUAL</h4>
                            <p class="card__text mbr-fonts-style display-4">Tenha acesso ao interior de monumentos em 360º<br><br><br></p>
                            
                        </div>
                    </div>
                    <div class="col-md-6 column2 d-flex flex-column justify-content-center">
                        <div class="card__block">
                            <div class="icon__block">
                                <span class="mbr-iconfont mbr-iconfont-1 mbri-responsive"></span>
                            </div>
                            <h4 class="card__title mbr-medium mbr-fonts-style display-5">DISPOSITIVOS
                            </h4>
                            <p class="card__text mbr-fonts-style display-4">Acesse em dispositivos variados​<br><br><br></p>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="header4 cid-tx4Dicodbv mbr-parallax-background" id="header04-q">
    

    <div class="mbr-overlay" style="opacity: 0.3; background-color: rgb(19, 23, 31);">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 title col-lg-9">

                
                <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-2 display-2"><strong><br></strong><br>Abrangência<br></h5>

            </div>
        </div>
        <div class="row">
            <div class="card col-12 col-md-6 md-pb col-lg-3">
                <div class="card-wrapper">
                    <div class="card-box align-left">

                        <h5 class="card-title mbr-fonts-style m-0 p-0 display-5"><strong>{{$acervos_total}}</strong></h5>

                    </div>
                    <p class="card-text align-left mbr-fonts-style pt-1 mb-0 display-5">Acervos</p>
                    
                </div>
            </div>
            <div class="card col-12 col-md-6 md-pb col-lg-3">
                <div class="card-wrapper">
                    <div class="card-box align-center">

                        <h5 class="card-title align-left mbr-fonts-style m-0 p-0 display-5"><strong>{{$obras_total}}</strong></h5>

                    </div>
                    <p class="card-text align-left mbr-fonts-style pt-1 mb-0 display-5">Obras</p>
                    
                </div>
            </div>
            <div class="card col-12 col-md-6 md-pb col-lg-3">
                <div class="card-wrapper">
                    <div class="card-box align-center">

                        <h5 class="card-title align-left mbr-fonts-style m-0 p-0 display-5"><strong>9</strong></h5>

                    </div>
                    <p class="card-text align-left mbr-fonts-style pt-2 mb-0 display-5">Vicariatos</p>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="video2 cid-tx5nlbWoh2" id="video2-12">
    
    
    <div class="container">
        <div class="mbr-section-head">
            <h4 class="mbr-section-title mbr-fonts-style display-2">
                Metodologia do Inventário<br><br></h4>
        </div>
        <div class="row align-items-center">
            <div class="col-12 col-lg-7 video-block">
                <div class="video-wrapper"><iframe class="mbr-embedded-video" src="https://www.youtube.com/embed/7tzgDzPKXOI?rel=0&amp;amp;mute=1&amp;showinfo=0&amp;autoplay=1&amp;loop=0" width="1280" height="720" frameborder="0" allowfullscreen></iframe></div>
            </div>
            <div class="col-12 col-lg">
                <div class="text-wrapper">
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="header5 expertm5 cid-tx5ugxUYP8" id="aheader5-17">

    

    
    

    <div class="container">
        <div class="row justify-content-end">
            <div class="col-12 col-lg-12">
                
                <h1 class="mbr-section-subtitle mbr-fonts-style display-2">Galeria Virtual<br></h1>
                <p class="mbr-text mbr-fonts-style display-7">Conheça algumas das peças inventariadas em 3D <br>e descubra mais detalhes!</p>
                <div class="mbr-section-btn custom-section-btn"><a class="btn btn-secondary display-7" href="{{route('galeria_3d')}}">Saiba mais</a></div>
            </div>
        </div>
    </div>
</section>

<section data-bs-version="5.1" class="features8 agencym4_features8 cid-tx5GwIH2zp mbr-parallax-background" id="features8-18">

	
    


	

	<div class="container">
		<div>
			<h2 class="mbr-fonts-style mb-4 align-center display-2"><a href="page5.html" class="text-info">Notícias</a><br><br></h2>
			<div class="media-container-row">
                @foreach ($blogs as $blog )
				<div class="card col-12 col-md-4">
					<div class="card-img">
						<img src="{{asset($blog->foto)}}" alt="Mobirise">
					</div>
					<div class="card-box">
						<p class="date mb-4"><span>{{date('d/m/Y', strtotime($blog->created_at)) }}</span></p>
						<h4 class="card-title mbr-fonts-style display-5">{{$blog->titulo}}</h4>
						
						<div class="mbr-section-btn"><a class="btn-underline mr-3 text-info text-primary display-4" href="{{url($blog->slug)}}">Saiba mais &gt;</a></div>
					</div>
				</div>
                @endforeach				
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="pricing1 cid-tx4PYWpmHy" id="pricing1-y">


    <div class="mbr-overlay" style="opacity: 0.2; background-color: rgb(19, 23, 31);">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <a href="https://produto.mercadolivre.com.br/MLB-3288902007"><img src="assets/images/livro-12-918x890.webp" class="top" alt=""></a>
            </div>
            <div class="col-12 col-md-6">
                <div class="right">

                    <p class="name mbr-fonts-style display-2"><br><br><br><br>Catálogo dos Bens Culturais da ArqRio
                    </p>

                    <div class="price-line">
                        <p class="desc2 mbr-fonts-style display-5"></p>
                        <p class="plus1 mbr-fonts-style display-5">
                            <strong>&nbsp;</strong>R$ 95,00 + Taxas
                        </p>
                    </div>
                    <p class="mbr-text mbr-fonts-style display-4">O catálogo aqui apresentado corresponde aos
                        produtos da primeira etapa do Inventário dos Bens Culturais da ArqRio</p>
                    <div class="mbr-section-btn"><a class="btn btn-secondary display-7" href="https://produto.mercadolivre.com.br/MLB-3288902007"
                            target="_blank"><span
                                class="mobi-mbri mobi-mbri-cash mbr-iconfont mbr-iconfont-btn"></span>Compre
                            agora</a></div>



                </div>
            </div>
        </div>
    </div>
</section>

<section class="elb-widgets cid-tx4K9e7EF4" id="eb-instagram-feed-w"><script src="https://s.electricblaze.com/widget.js" defer=""></script>
<div class="electricblaze-id-2Uhx8AJ"></div></section>

<section class="eb-youtube-feed cid-tx4K8GGLqB" id="eb-youtube-feed-v"><script src="https://s.electricblaze.com/widget.js" defer=""></script>
<div class="electricblaze-id-2Uhx8AI"></div></section>
	
@include('web.layout.footer')
@endsection
			
			
			




