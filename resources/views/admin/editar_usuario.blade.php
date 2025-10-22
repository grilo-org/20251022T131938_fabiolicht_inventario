@extends('layouts.app')

@section('titulo', 'Cadastro de Acervo')

@section('content')

    @php
        $allowEdit = ['1', '2'];
        $canOnlyView = [];
    @endphp

    <div class="main-content" style="min-height: 562px;">
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
                            <form method="POST"  enctype="multipart/form-data"
                                action="@if (in_array(strval(auth()->user('id')['id_cargo']), $allowEdit)) {{ route('atualizar_usuario', ['id' => $usuario->id]) }} @endif"
                                name="criar_usuario" accept-charset="utf-8">
                                @if (in_array(strval(auth()->user('id')['id_cargo']), $allowEdit))
                                    @csrf
                                @endif
                                <div class="card-header">
                                    <h4> Editar Usuário </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Nome do usuário</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user text-info"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="edit_nome_usuario"
                                                    value="{{ $usuario->name }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('edit_nome_usuario') }}</small>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>E-mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-map-marker-alt text-info"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control cep" id="edit_email_usuario"
                                                    name="edit_email_usuario" value="{{ $usuario->email }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('edit_email_usuario') }}</small>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Foto</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-image text-info"></i>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control" name="edit_foto_usuario">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div id="box-foto-usuario">
                                                <div id="image_holder_user"></div>
                                            </div>
                                            <input type="hidden" name="usuario_id" value="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"
                                        @if (in_array(strval(auth()->user('id')['id_cargo']), $canOnlyView)) disabled @endif>Salvar</button>
                                    <a href="{{ route('home') }}" class=" btn btn-dark">voltar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Home da área restrita -->
                </div>
            </div>
        </section>
    </div>

    @include('sweetalert::alert')
    <script>
        $(document).ready(function() {
            function ajax_sub(control, image_holder) {
                //Get count of selected files
                var countFiles = control[0].files.length;
                var imgPath = control[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                image_holder.empty();
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof(FileReader) != "undefined") {
                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("<img />", {
                                    "src": e.target.result,
                                    "class": "thumb-image",
                                    "style": "width:100px; max-height: 200px;"
                                }).appendTo(image_holder);
                            }
                            image_holder.show();
                            reader.readAsDataURL(control[0].files[i]);
                        }
                    } else {
                        alert("Este navegador não suporta FileReader.");
                    }
                } else {
                    alert("Por favor, selecione apenas com formatos válidos.");
                }
            }

            $("input[name='foto_usuario']").on('change', function() {
                ajax_sub($("input[name='foto_usuario']"), $("#image_holder_user"));
            });

            $("#acesso_acervo_usuario_all").on('change', function() {
                if ($("#acesso_acervo_usuario_all").is(":checked")) {
                    $("input.notall").attr("disabled", true); 
                    $("input.notall").prop("checked", false);
                } else {
                    $("input.notall").removeAttr("disabled");
                }
            });

        });
    </script>

@endsection
