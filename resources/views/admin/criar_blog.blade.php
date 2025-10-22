@extends('layouts.app')

@section('titulo', 'Cadastro de Notícias')

@section('content')
<div class="main-content" style="min-height: 562px;">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <form method="POST" action="{{route('salvar_blog')}}"  name="salvar_blog"  enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4> Adicionar Notícia </h4>
              </div>
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Título</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-info"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="titulo_blog" value="{{ old('titulo_blog') }}" required>
                    </div>
                    <small class="text-danger">{{ $errors->first('titulo_blog') }}</small>
                  </div>
                  
                  <div class="form-group col-md-12">
                    <label>Conteúdo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                      </div>
                      <textarea class="form-control" name="descricao_blog" style="min-height: 200px;"></textarea>
                    </div>
                    <small class="text-danger">{{ $errors->first('descricao_blog') }}</small>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Foto</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-image text-info"></i>
                        </div>
                      </div>
                      <input type="file" class="form-control" name="foto_blog">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div id="box-foto-usuario">
                      <div id="image_holder_blog"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
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

<script>
  function ajax_sub(control, image_holder){
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

    $("input[name='foto_blog']").on('change', function() {
        ajax_sub($("input[name='foto_blog']"), $("#image_holder_blog"));
    });
</script>

@include('sweetalert::alert')
@endsection
