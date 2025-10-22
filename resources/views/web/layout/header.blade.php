<!DOCTYPE html>
<html>

<head>
    <!-- Site made with Mobirise Website Builder v5.8.9, https://mobirise.com -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="Mobirise v5.8.9, mobirise.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="{{url('assets/images/logo-arq-rio-branca-01-332x130.webp')}}" type="image/x-icon">
    <meta name="description" content="">

    <title>@yield('titulo', 'Nome Padrão')</title>
    <link rel="stylesheet" href="{{url('assets/web/assets/mobirise-icons2/mobirise2.css')}}">
    <link rel="stylesheet" href="{{url('assets/web/assets/mobirise-icons/mobirise-icons.css')}}">
    <link rel="stylesheet" href="{{url('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/bootstrap/css/bootstrap-grid.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/bootstrap/css/bootstrap-reboot.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/parallax/jarallax.css')}}">
    <link rel="stylesheet" href="{{url('assets/animatecss/animate.css')}}">
    <link rel="stylesheet" href="{{url('assets/dropdown/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/socicon/css/styles.css')}}">
    <link rel="stylesheet" href="{{url('assets/theme/css/style.css')}}">
    <link rel="preload"
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap">
    </noscript>
    <link rel="preload"
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,300i,400i,500i,600i,700i,800i&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,300i,400i,500i,600i,700i,800i&display=swap">
    </noscript>
    <link rel="stylesheet" href="{{ url('assets/mobirise/css/mbr-additional.css') }}">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">

</head>

<body>

    <section data-bs-version="5.1" class="menu menu1 expertm5 cid-thXKMbTk5w" once="menu" id="amenu1-0">

        <nav class="navbar navbar-dropdown navbar-expand-lg">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <span class="navbar-logo">
                        <a href="{{route('portal')}}">
                            <img src="{{url('assets/images/logo-arq-rio-branca-01-332x130.webp')}}" alt="Mobirise Website Builder"
                                style="height: 5.8rem;">
                        </a>
                    </span>

                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse"
                    data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                        <li class="nav-item">
                            <a class="nav-link link text-info text-primary display-4" href="{{route('portal')}}">INÍCIO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-info text-primary display-4" href="{{route('sobre')}}">SOBRE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-info text-primary display-4" href="{{route('busca_obras_publico2')}}">BUSCAR
                                OBRAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link text-info text-primary display-4" href="{{route('tour_3d')}}">TOUR
                                360°</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-info text-primary display-4" href="#" id="navbarDropdownGaleria" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                GALERIA
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownGaleria">
                                <a class="dropdown-item text-white" href="{{route('galeria_3d')}}">GALERIA 3D</a>
                                <a class="dropdown-item text-white" href="{{route('acervo_publico')}}">ACERVOS</a>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link link text-info text-primary display-4"
                                href="{{route('educacao')}}">EDUCAÇÃO PATRIMONIAL</a>
                        </li>
                        <li class="nav-item"><a class="nav-link link text-info text-primary display-4"
                                href="{{route('noticias')}}">NOTÍCIAS</a></li>
                                <li class="nav-item"><a class="nav-link link text-info text-primary display-4"
                                    href="{{route('exposicao')}}">CAPACITAÇÕES E
                                    EXPOSIÇÕES</a></li>
                    </ul>

                    <div class="navbar-buttons mbr-section-btn custom-section-btn"><a
                            class="btn btn-secondary display-7" href="{{route('login')}}">LOGIN</a></div>
                </div>
            </div>
        </nav>
    </section>
@yield('content')