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

            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" href="/home">Abertas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{{ route('ccint.avaliacoesFinalizadas') }}">
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
                      @if(isset($avaliacao->candidatura->carta))
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
                              <a href="#visualizarModal_{{ $avaliacao->id }}" data-toggle="modal" class="btn btn-primary btn-sm"> Visualizar</a>

                               <!-------------   MODAL ---------------------->      

                              <div class="modal fade" id="visualizarModal_{{ $avaliacao->id }}">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              Avaliação {{ $avaliacao->candidatura->candidato->nome }}
                                          </div>
                                          <div class="modal-body">
                                              <table class="table">
                                                <tbody>
                                                  <tr>
                                                      <td>Planos de trabalho</td>
                                                      <td>
                                                        @isset($avaliacao->plano_trabalho)
                                                          {{ $avaliacao->plano_trabalho }}
                                                        @endif
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td>Currículo Lattes</td>
                                                      <td>@isset($avaliacao->curriculum_lattes)
                                                          {{ $avaliacao->curriculum_lattes }}
                                                        @endif
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td>Carta de Recomendação</td>
                                                      <td>@isset($avaliacao->carta)
                                                          {{ $avaliacao->carta }}
                                                        @endif
                                                      </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancelar
                                              </button>

                                              @if($avaliacao->candidatura->edital->status_edital_id == 9)
                                                <a  href="{{ route('ccint.detalhes', $avaliacao->candidatura->id) }}" class="btn btn-success">
                                                    Refazer
                                                </a>
                                              @endif
                                              
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!------------- FIM  MODAL ----------------------> 

                            </td>
                          </tr>
                        @endif
                      @endif
                    @endforeach
                  @else
                    <p>Não existe nenhum candidato para ser avaliado no momento!</p>
                  @endif
                  </tbody>
                </table>
                {{ $avaliacoes->links("pagination::bootstrap-4") }}
              </div>
            </div>
          </div>
        </div>
    </div>



@endsection

@section('scripts')



@endsection