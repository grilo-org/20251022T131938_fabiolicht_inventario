@extends('layouts.app')

@section('titulo', 'Obras cadastradas')

@php
    $allowEdit = ['1', '2', '4', '5'];
    $canOnlyView = ['6'];
    $allowDelete = ['1', '2'];
@endphp

<div class="main-content">
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
        background: rgba(0,0,0,.8);
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
  {!! csrf_field() !!}

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Obras</h4>
          <div class="card-header-form">
            <a data-toggle='tooltip' data-placement='top' title="Cadastrar Obra" href="{{route('criar_obra')}}" class="btn btn-primary mr-2 float-right">Cadastrar</a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <nav>
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="{{$obras->previousPageUrl()}}">Voltar</a></li>
                @for($i = 1; $i <= $obras->lastPage(); $i++)
                  <li class="page-item {{$obras->currentPage() == $i ? 'active': '' }} "><a class="page-link" href="{{$obras->url($i)}}">{{$i}}</a></li>
                @endfor
                <li class="page-item"><a class="page-link" href="{{$obras->nextPageUrl()}}">Avançar</a></li>
              </ul>
            </nav>
            <table class="table table-striped" id="table-obras">
              <thead>
                <tr>
                  <th style="padding-left:25px; text-align: center;">Id</th>
                  <th style="text-align: center;">Foto Principal</th>
                  <th>Título</th>
                  <th>Tesauro</th>
                  <th>Acervo</th>
                  <th>Material</th>
                  <th>Século</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($obras as $obra)
                <tr>
                 <td style="padding-left:25px; text-align: center;">{{ $obra->id }}</td>
                  <td class="align-middle text-center">
                    <a href="{{ route('detalhar_obra', ['id' => $obra->id]) }}">
                      @if($obra->foto_frontal_obra)
                      <img class="team-member-sm" src="{{ asset($obra->foto_frontal_obra) }}" alt="obra_{{ $obra->id }}"
                        data-toggle="tooltip" title="obra_{{ $obra->id }}" data-original-title="Foto frontal">
                      @else
                      <img class="team-member-sm" src="{{ asset('img/noimg.png') }}" alt="obra_{{ $obra->id }}"
                        data-toggle="tooltip" title="obra_{{ $obra->id }}" data-original-title="Foto frontal">
                      @endif
                    </a>
                  </td>
                  <td>{{ $obra->titulo_obra }}@if($obra->obra_provisoria == 1)<div style="border-radius: 11px; border-color: rgb(255, 71, 111); background-color:rgb(255, 204, 215); border-width: 2px; border-style: dashed; margin-left: 2%; padding-left: 2%; padding-right: 2%; color: rgb(255, 71, 111); display: inline-block; font-family: 'Baloo Paaji';">T</div>@endif
                  </td>
                  <td>{{ $obra->titulo_tesauro }}</td>
                  <td>{{$obra->acervo_id.'-'. $obra->nome_acervo }}</td>
                  <td>{{ $obra->titulo_material_1 }}</td>
                  <td>{{ $obra->titulo_seculo }}</td>
                  <td id="interacoes">
                    <a href="{{ route('detalhar_obra', ['id' => $obra->id]) }}" class="btn btn-outline-success"target="_blank"><i
                        class="far fa-eye"></i></a>
                    <a href="@if(in_array(strval(auth()->user('id')['id_cargo']), $allowEdit)) {{ route('editar_obra', ['id' => $obra->id]) }} @else # @endif" class="btn btn-outline-primary" @if(in_array(strval(auth()->user('id')['id_cargo']), $canOnlyView)) disabled @endif target="_blank"><i class="fas fa-edit"></i></a>
                    @if(in_array(strval(auth()->user('id')['id_cargo']), $allowDelete))
                    <a href="#" class="btn btn-danger deletanovo" id="{{ $obra->id }}"
                      name="{{ $obra->titulo_obra }}"><i class="fas fa-trash"></i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <nav>
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="{{$obras->previousPageUrl()}}">Voltar</a></li>
                @for($i = 1; $i <= $obras->lastPage(); $i++)
                  <li class="page-item {{$obras->currentPage() == $i ? 'active': '' }} "><a class="page-link" href="{{$obras->url($i)}}">{{$i}}</a></li>
                @endfor
                <li class="page-item"><a class="page-link" href="{{$obras->nextPageUrl()}}">Avançar</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div id="loader" class="lds-dual-ring hidden overlay"></div>
        <!-- Home da área restrita -->

  </div>
</div>

<script>
  $(".deletanovo").click(function (e) {
  e.preventDefault();
  let id_obra = $(this).attr('id');
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
        $.ajax({
          url: 'obra/deletar/'+ id_obra,
          type: 'POST',
          headers: {
              'X-CSRF-TOKEN': $('input[name=_token]').val()
          }}).done(function(data) {
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
