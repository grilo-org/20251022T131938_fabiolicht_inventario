@extends('web.layouts.app')

@section('titulo', 'Buscar Obras')

@section('content')

    <style>
        body {
            background: #ececec;
        }

        .lds-dual-ring.hidden {
            display: none;
        }

        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 5% auto;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }


        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, .8);
            z-index: 999;
            opacity: 1;
            transition: all 0.5s;
        }

        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 30%;
            height: auto;
            object-fit: cover;
        }
    </style>

    <div class="busca-obras-publico" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                @if (session()->has('alert_type'))
                    <div id="msg" class="alert alert-{{ session()->pull('alert_type') }} alert-dismissible fade show"
                        role="alert">
                        {{ session()->pull('alert_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div id="anoerror">
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form id="busca_form2" type="POST" action="" name="criar_obra" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4> Busca Obras </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>O que deseja pesquisar?</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user text-info"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="titulo_obra"
                                                    value="{{ old('titulo_obra') }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('titulo_obra') }}</small>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" id="buscar"><i
                                                class="fas fa-search"></i>&nbsp;Buscar</button>
                                        <a href="{{ route('busca_obras_publico') }}" class=" btn btn-success">Busca
                                            Avançada</a>
                                        <a href="{{ route('portal') }}" class=" btn btn-dark">voltar</a>

                                    </div>
                            </form>
                        </div>
                        <div id="quantidade"></div>
                        <div class="card">
                            <div class="card-body">
                                <div id="buscaObras2" class="row">
                                </div>
                            </div>
                        </div>
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>
                        <!-- Home da área restrita -->

                    </div>
                </div>
        </section>
    </div>

    <script>
        $(document).on('submit', '#busca_form2', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            $('#quantidade').empty();
            $('#loader').removeClass('hidden')
            $.ajax({
                url: '{{ route('busca_obras_publico_form2') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                data: $(this).serialize(),

            }).done(function(data) {
                console.log(data);
                $('#loader').addClass('hidden')
                $('#quantidade').empty().append("Foram encontradas <b>" + data.quantidade + "</b> obras.");
                $('#buscaObras2').empty().append(data.controles);
            });
        });

        $(document).on('click', '.deletanovo', function(e) {
            e.preventDefault();
            let id_obra = $(this).data('id');
            let titulo_obra = $(this).attr('name');

            var botao = $(this);

            swal({
                title: 'Tem certeza?',
                text: 'Deseja deletar a obra ' + titulo_obra + '?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#loader').removeClass('hidden')
                    $.ajax({
                        url: '/obra-publico/deletar/' + id_obra,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name=_token]').val()
                        }
                    }).done(function(data) {
                        $('#loader').addClass('hidden')
                        if (data.status == 'success') {
                            swal('Sucesso!', data.msg, 'success');
                            botao.parent().parent().remove();
                        } else {
                            swal('Erro!', data.msg, 'error');
                        }
                    });
                }
            });
        });
    </script>

@endsection
