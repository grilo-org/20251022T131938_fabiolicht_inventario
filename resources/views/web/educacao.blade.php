	@extends('web.layout.header')
	@section('titulo', 'EDUCAÇÃO Patrimonial')	
    @section('content')
    

    <section data-bs-version="5.1" class="header2 lodgem5 cid-tx5YaqMFEi mbr-parallax-background" id="aheader2-1g">

    

    
    

        <div class="align-center container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <h1 class="mbr-section-title mbr-fonts-style align-center mbr-white display-2"><br><br>EDUCAÇÃO<br>Patrimonial</h1>
                    
                    
                </div>
            </div>
        </div>
    </section>
    
    @foreach ($videos as $video)
    <section data-bs-version="5.1" class="cid-tx5YJ0dZ6E mb-15" id="video1-1i">
    
        
    
        
    
        
        <figure class="mbr-figure align-center container">
            <div class="video-block" style="width: 66%;">
                <div><iframe class="mbr-embedded-video" src="https://www.youtube.com/embed/{{$video->url}}?rel=0&amp;amp;&amp;showinfo=0&amp;autoplay=0&amp;loop=0" width="1280" height="720" frameborder="0" allowfullscreen></iframe></div>
            </div>
        </figure>
       
    </section>
    
    @endforeach



	@include('web.layout.footer')		
@endsection
	




