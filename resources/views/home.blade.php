@extends('layouts.site')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="font-weight-bold mb-0">Mobilidade Out</h4>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title mb-0">Editais Abertos</p>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                       <th>Nome</th>
                       <th>Número</th>
                       <th>Bolsas</th>
                       <th>Encerramento Inscrição</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($editais as $edital)
                      <tr>
                        <td>
                          @isset($edital->nome)
                            {{ $edital->nome }}</td>
                          @endif
                        <td> 
                          @isset($edital->numero)
                            {{ $edital->numero }}
                          @endif
                        </td>
                        <td>
                          @isset($edital->qtd_bolsas)
                            {{ $edital->qtd_bolsas }}</td>
                          @endif
                        <td> 
                          @isset($edital->fim_inscricao)
                            {{ $edital->fim_inscricao->format('d/m/Y') }}
                          @endif
                        </td>
                         <td>
                          <a  href="editais/download/{{ $edital->id }}" class="btn btn-success btn-sm">
                              Visualisar
                          </a>
                        </td>
                        @if(Auth::user()->privilegio == 1)
                          <td>
                            {{ $inscrito = false }}
                            @foreach ($candidaturas as $candidatura)
                                @if($candidatura->edital_id == $edital->id)
                                  @php 
                                    $inscrito = true  
                                  @endphp
                                @endif
                            @endforeach
                            @isset($candidato)
                              @if($inscrito == false)
                                <a  href="candidaturas/inscricao/{{ $edital->id }}" class="btn btn-primary btn-sm">
                                  {{ __('Inscrever') }}
                                </a>
                              @else
                                <a  href="candidaturas/atualizacao/{{ $edital->id }}" class="btn btn-secondary btn-sm">
                                  {{ __('Editar') }}
                                </a>
                              @endif
                            @else
                              <button type="submit" data-toggle="modal" data-target="#editalModal"  class="btn btn-primary btn-sm">
                                {{ __('Inscrever') }}
                              </button>
                            @endif
                          </td>
                          @else
                          <td>
                            <a href="/editais/detalhes/{{ $edital->id }}"  class="btn btn-primary btn-sm"> Detalhes</a>
                          </td>
                          @endif
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Modal-->
<div class="modal fade" id="editalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Atualizar dados</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="GET" action="candidato" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div>
              <p>
                Você ainda não atualizou seus dados! Para se inscrever é necessário atualizar seus dados.
              </p>
              
            </div>
            <div class="modal-footer">
              <div class="mt-3">
                <div class="form-group">
                  <div class="input-group">
                    <button type="submit"  class="btn btn-primary btn-sm">
                      {{ __('Atualizar') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection