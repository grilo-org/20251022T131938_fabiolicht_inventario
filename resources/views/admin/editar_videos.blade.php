@extends('layouts.app')

@section('titulo', 'Editar vídeo')

@section('content')
<div class="main-content" style="min-height: 562px;">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <form method="POST" action="{{route('atualizar_video', ['id' => $videos->id])}}"  name="atualizar_videos"  enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4> Edtiar Vídeo </h4>
              </div>
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Título</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-info"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="edit_titulo_video" value="{{$videos->titulo}}" required>
                    </div>
                    <small class="text-danger">{{ $errors->first('edit_titulo_video') }}</small>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Url Vídeo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-file-video"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="edit_url_video" value="{{$videos->url}}" required>
                    </div>
                    <small class="text-danger">{{ $errors->first('edit_url_video') }}</small>
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
@include('sweetalert::alert')
@endsection
