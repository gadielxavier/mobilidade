@extends('layouts.site')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="font-weight-bold mb-0">Avaliação Ccint</h4>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-12 grid-margin stretch-card">
          <div class="card">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active"href="/home">Abertas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ccint.avaliacoesFinalizadas') }}">
                  Avaliações Finalizadas
                </a>
              </li>
            </ul>


            <div class="card-body">
              <p class="card-title mb-0">Candidatos</p>
              <div class="table-responsive">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
              @if(isset($avaliacoes[0]))
                <table class="table table-striped">
                  <thead>
                    <tr>
                       <th>Nome</th>
                       <th>Edital</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($avaliacoes as $avaliacao)
                      @if($avaliacao->candidatura->carta != '0')
                        <tr>
                            <td>
                              @isset($avaliacao->candidatura->candidato->nome)
                                {{ $avaliacao->candidatura->candidato->nome }}
                              @endif
                            </td>
                            <td>
                              @isset($avaliacao->candidatura->edital->nome)
                                {{ $avaliacao->candidatura->edital->nome.'  '.$avaliacao->candidatura->edital->numero }}
                              @endif
                            </td>
                            <td>
                              <a  href="ccint/detalhes/{{ $avaliacao->candidatura->id }}" class="btn btn-success btn-sm">
                                  Visualizar
                              </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                  @else
                  <p>Não existe nenhum candidato para ser avaliado no momento!</p>
                  @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection


@section('scripts')



@endsection