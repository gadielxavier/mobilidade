@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
  		<h4 class="card-title">Acompanhar Inscrição</h4>
      <p class="card-description">Status</p>
      <div class="form-group">
        <p>{{ $candidatura->status->titulo }}</p>

        @if( $candidatura->status->id ==  3 || $candidatura->status->id == 11 )
        <p class="card-description">Entrar com Recurso</p>
          <button type="submit" data-toggle="modal" data-target="#editalModal"  class="btn btn-primary btn-sm">
            {{ __('Recurso') }}
          </button>
        @endif
      </div>
      <div class="form-group">
        @if($candidatura->status->id > 13 )
          @if($avaliacao != null && $avaliacao->posicao != '0')
          <p>
            <p class="card-description">Resultado</p>
            Sua posição é {{ $avaliacao->posicao }}º em um edital com {{ $edital->qtd_bolsas }} bolsas ofertadas
          </p>
          @endif
        @endif
      </div> 
      <div class="form-group">
        @if(isset($recursos[0]))
          <p class="card-description">Recursos</p>
          <table class="table table-striped">
              <tbody>
              @foreach ($recursos as $recurso)
                  <tr>
                    <td>
                        @isset($recurso->candidato->id)
                          @if(strlen($recurso->description) > 15 )
                            {{ substr($recurso->description,0,15).('...')}}
                          @else
                            {{ $recurso->description }}
                          @endif 
                        @endif
                    </td>
                    <td> 
                        @isset($recurso->edital->id)
                          {{ $recurso->created_at->format('d/m/Y  H:i:s') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('candidaturas.recurso', $recurso->id) }}"  class="btn btn-primary btn-sm"> Visualizar</a>
                    </td>
                </tr>
               </tbody>
            @endforeach
           </table>
        @endif
      </div>     
      <div class="form-group">
        @if($candidatura->certificado != '0')
          <p class="card-description">Certificado de Proeficiência</p>
          <a  href="{{ route('candidaturas.certificado', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
            Visualizar
          </a>
        @endif
      </div>
		</div>
	</div>

  <!-- Modal-->
  <div class="modal fade" id="editalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Recurso</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="{{ route('recurso', $candidatura->id) }}">
            {{ csrf_field() }}
              <div>
                <p>
                  Qual o motivo para entrada do recurso?
                </p>
                <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                
              </div>
              <div class="modal-footer">
                <div class="mt-3">
                  <div class="form-group">
                    <div class="input-group">
                      <button type="submit"  class="btn btn-primary btn-sm">
                        {{ __('Enviar') }}
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
</div>

@endsection