@extends('layouts.app')

@section('titulo', 'Cadastro de Vídeos')

@section('content')
<div class="main-content" style="min-height: 562px;">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <form method="POST" action="{{route('salvar_video')}}"  name="salvar_videos"  enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4> Adicionar Vídeo </h4>
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
                      <input type="text" class="form-control" name="titulo_video" value="{{ old('titulo_video') }}" required>
                    </div>
                    <small class="text-danger">{{ $errors->first('titulo_video') }}</small>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Url Vídeo</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-file-video"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="url_video" value="{{ old('url_video') }}" required>
                    </div>
                    <small class="text-danger">{{ $errors->first('url_video') }}</small>
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
