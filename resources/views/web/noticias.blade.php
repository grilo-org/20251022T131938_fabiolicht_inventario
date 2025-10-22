	@extends('web.layout.header')
	@section('titulo', 'Notícias')	
    @section('content')
    

    <section data-bs-version="5.1" class="header2 lodgem5 cid-tx5Zu8BVwD" id="aheader2-1l">

    

        <div class="align-center container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <h1 class="mbr-section-title mbr-fonts-style align-center mbr-white display-2"><br><br><br>NOTÍCIAS</h1>
                    
                    
                </div>
            </div>
        </div>
    </section>
    
    <section data-bs-version="5.1" class="news1 lodgem5 cid-tx5ZFJKQhH" id="anews1-1m">
    
        
    
        
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="main-container">
                        @foreach ($blogs as $blog )
                        @if($blog->id % 2 == 0)
                        <div class="history-item history-item-first">
                            <div class="item-circle"></div>
                            <div class="img-container">
                                <div class="image-wrapper">
                                    <img src="{{asset($blog->foto)}}" alt="{{$blog->titulo}}">
                                </div>
                            </div>
                            <div class="text-container">
                                <div class="text-wrapper">
                                    <h4 class="card-title mbr-fonts-style mb-0 display-5">
                                        {{date('d/m/Y', strtotime($blog->created_at)) }}</h4>
                                    <h4 class="card-subtitle mbr-fonts-style mb-0 display-2">{{$blog->titulo}}</h4>
                                    <p class="mbr-text mbr-fonts-style mb-0 display-7"><a href="{{url($blog->slug)}}" class="text-secondary">Acesso a notícia &gt;</a></p>
                                    
                                </div>
                            </div>
                        </div>
                       
                    @else
                    <div class="history-item history-item-reverse">
                        <div class="item-circle"></div>
                        <div class="text-container">
                            <div class="text-wrapper">
                                <h4 class="card-title mbr-fonts-style mb-0 display-5">{{date('d/m/Y', strtotime($blog->created_at)) }}
                                </h4>
                                <h4 class="card-subtitle mbr-fonts-style mb-0 display-2">{{$blog->titulo}}</h4>
                                <p class="mbr-text mbr-fonts-style mb-0 display-7">
                                    <a href="{{url($blog->slug)}}" class="text-secondary">Acesso a notícia &gt;</a>
                                </p>
                                
                            </div>
                        </div>
                        <div class="img-container">
                            <div class="image-wrapper">
                                <img src="{{asset($blog->foto)}}" alt="Mobirise Website Builder">
                            </div>
                        </div>
                    </div>
                       
                    @endif
   
                        <div class="center-line"></div>
                       
    
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


	@include('web.layout.footer')		
@endsection
	




