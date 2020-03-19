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
            <div class="card-body">
              <p class="card-title mb-0">Candidatos para Avaliação</p>
              <div class="table-responsive">
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
                      <tr>
                          <td>
                          @isset($avaliacao->candidatura->candidato->nome)
                            {{ $avaliacao->candidatura->candidato->nome }}</td>
                          @endif
                          </td>
                          <td>
                          @isset($avaliacao->candidatura->edital->nome)
                            {{ $avaliacao->candidatura->edital->nome.'  '.$avaliacao->candidatura->edital->numero }}</td>
                          @endif
                          </td>
                          <td>
                          <a  href="ccint/detalhes/{{ $avaliacao->candidatura->id }}" class="btn btn-success btn-sm">
                              Visualizar
                          </a>
                        </td>
                      </tr>
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