@extends('web.layout.header')

@section('content')


<section data-bs-version="5.1" class="form stackm5 cid-tx61pSAJfz" id="form01-1n">


    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="mbr-section-title mbr-fonts-style align-center mb-5 display-5">
                    <br><br><br>ACESSO<br><strong><br></strong>
                </h3>
            </div>
            <div class="col-lg-6 mx-auto mbr-form" data-form-type="formoid">
                <!--Formbuilder Form-->
                <!-- <form action="https://mobirise.eu/" method="POST" class="mbr-form form-with-styler"
                    data-form-title="Form Name"><input type="hidden" name="email" data-form-email="true"
                        value="0OPO/wNy5uQghsarn4sA9lc0/nwqlwVErigq410Rji0IENEnu+2XRENmMMSstInzfZ8Z47mr+5tnZGidy1FW0qIUswVRHR76d1LRLMjbvnzmbmbE1ZMIMXDcKMetJUAy.jruuyAflXyUlE41S1lxNEuBVceqjKll4D4Aj2Am5bACHMGU0s3Iq1k4ov1ReRrxeyAvvOO1yQ2XaW7RpP3MX/rLr/6DYjKJbpr6y3Yhwdpxo7xnsQplDdziwRlq7r5GQ">
                    <div class="row">
                        <div hidden="hidden" data-form-alert="" class="alert alert-success col-12"></div>
                        <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">Oops...!
                            some
                            problem!</div>
                    </div>
                    <div class="dragArea row">
                        <div class="col-lg-6 col-md-12 col-sm-12 form-group mb-3" data-for="name">
                            <input type="text" name="name" placeholder="Nome" data-form-field="name"
                                class="form-control display-7" value="" id="name-form01-1n">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 form-group mb-3" data-for="email">
                            <input type="email" name="email" placeholder="Senha" data-form-field="email"
                                class="form-control display-7" value="" id="email-form01-1n">
                        </div>
                        <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group mb-3">
                            <input type="tel" name="phone" placeholder="Phone" data-form-field="phone"
                                class="form-control display-7" pattern="*" value="" id="phone-form01-1n">
                        </div>
                        <div data-for="message" class="col-lg-12 col-md-12 col-sm-12 form-group mb-3">
                            <textarea name="message" placeholder="Message" data-form-field="message"
                                class="form-control display-7" id="message-form01-1n"></textarea>
                        </div>
                        <div class="col-auto m-auto"><button type="submit"
                                class="w-100 btn btn-white-outline display-7">SEND MESSAGE<br><br></button></div>
                    </div>
                </form> -->
                
                <form method="POST" action="{{ route('login') }}">

                    {{ csrf_field() }}
                  
                    <div class="row mb-3">
                        <label style="color: white;" for="email" class="col-md-4 col-form-label text-md-end ">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control " placeholder="E-mail" name="email" value="" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label style="color: white;" for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                        <div class="col-md-6">
                            <input id="password" type="password" placeholder="Senha" class="form-control " name="password" required autocomplete="current-password">

                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                <label style="color: white;" class="form-check-label" for="remember" >
                                    Manter Conectado
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                    Login
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Esqueceu sua senha?
                            @endif
                            </a>
                        </div>
                    </div>
                </form>
                <!--Formbuilder Form-->
            </div>
        </div>
    </div>
    
</section>
@include('web.layout.footer')	
@include('sweetalert::alert')

@endsection