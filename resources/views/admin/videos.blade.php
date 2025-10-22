@extends('layouts.app')

@section('titulo', 'Vídeos')

@php
    $allowEdit = ['1', '2', '4', '5'];
    $canOnlyView = ['6'];
    $allowDelete = ['1', '2'];
@endphp

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
      background: rgba(0,0,0,.8);
      z-index: 999;
      opacity: 1;
      transition: all 0.5s;
  }

  </style>

<div class="main-content">
  @section('content')
  <div id="loader" class="lds-dual-ring hidden overlay"></div>
  {!! csrf_field() !!}

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Vídeos</h4>
          <div class="card-header-form">
            <a data-toggle='tooltip' data-placement='top' title="Cadastrar Vídeos" href="{{route('criar_videos')}}" class="btn btn-primary mr-2 float-right">Cadastrar</a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped" id="table-videos">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Título</th>
                  <th>Url</th>
                  <th>Criado</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($videos as $vid)
                <tr>
                 <td style="padding-left:25px; text-align: center;">{{ $vid->id }}</td>
                 
                  <td>{{ $vid->titulo }}</td>
                  <td>{{ $vid->url }}</td>
                  <td>{{date('d/m/Y H:i:s', strtotime($vid->created_at)) }}</td>
                  <td id="interacoes">
                  <a href="@if(in_array(strval(auth()->user('id')['id_cargo']), $allowEdit)) {{ route('editar_video', ['id' => $vid->id]) }} @else # @endif" class="btn btn-outline-primary" @if(in_array(strval(auth()->user('id')['id_cargo']), $canOnlyView)) disabled @endif target="_blank"><i class="fas fa-edit"></i></a>
                    @if(in_array(strval(auth()->user('id')['id_cargo']), $allowDelete))
                    <a href="#" class="btn btn-danger deletanovo" id="{{ $vid->id }}"
                      name="{{ $vid->titulo }}"><i class="fas fa-trash"></i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(".deletanovo").click(function (e) {
  e.preventDefault();
  let id_video = $(this).attr('id');
  let titulo = $(this).attr('name');
  var botao = $(this);

  swal({
    title: 'Tem certeza?',
    text: 'Deseja deletar o vídeo ' + titulo + '?',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
      if (willDelete) {
        $('#loader').removeClass('hidden')
        $.ajax({
          url: '/admin/videos/delete/'+ id_video,
          type: 'POST',
          headers: {
              'X-CSRF-TOKEN': $('input[name=_token]').val()
          }}).done(function(data) {
            $('#loader').addClass('hidden')
          if(data.status == 'success') {
            swal('Sucesso!', data.msg, 'success');
            botao.parent().parent().remove();
          }else{
            swal('Erro!', data.msg, 'error');
          }
        });
      }
    });
});

</script>

@endsection
