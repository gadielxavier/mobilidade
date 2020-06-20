@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      		<h4 class="card-title">Acompanhar Inscrição</h4>

          @if($candidatura->status->id == 1)
           <p>{{ $candidatura->status->titulo }}</p>
          @elseif( $candidatura->status->id ==  2 )
            <p>{{ $candidatura->status->titulo }}</p>
          @elseif( $candidatura->status->id ==  3 )
            <p>{{ $candidatura->status->titulo }}</p>
            <button type="submit" data-toggle="modal" data-target="#editalModal"  class="btn btn-primary btn-sm">
              {{ __('Recurso') }}
            </button>
          @elseif( $candidatura->status->id ==  4 )
            <p>{{ $candidatura->status->titulo }}</p>

            @isset($recurso->candidato->nome)
            <div class="card">
                <div class="card-body" style="background-color:powderblue;">
                  <h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
                  <p>
                    {{ $recurso->description }}
                  </p>
                </div>
            </div>
            @endif

            @isset($resposta->description)
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Aeri</h4>
                  <p>
                    {{ $resposta->description }}
                  </p>
                </div>
            </div>
            @endif

          @elseif( $candidatura->status->id ==  5 )
            <p>{{ $candidatura->status->titulo }}</p>

             @isset($recurso->candidato->nome) 
             <div class="card">
                <div class="card-body" style="background-color:powderblue;">
                  <h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
                  <p>
                    {{ $recurso->description }}
                  </p>
                </div>
            </div>
            @endif

            @isset($resposta->description)
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Aeri</h4>
                  <p>
                    {{ $resposta->description }}
                  </p>
                </div>
            </div>
            @endif

          @elseif( $candidatura->status->id ==  6 )
            <p>{{ $candidatura->status->titulo }}</p>

             <a  href="{{ route('candidaturas.certificado', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
              Visualizar
            </a>

          @elseif( $candidatura->status->id ==  7 )
            <p>{{ $candidatura->status->titulo }}</p>

            <a  href="{{ route('candidaturas.certificado', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
              Visualizar
            </a>


          @elseif( $candidatura->status->id ==  9 )
            <p>{{ $candidatura->status->titulo }}</p>
          @elseif( $candidatura->status->id == 10 )
            <p>{{ $candidatura->status->titulo }}</p>
          @elseif( $candidatura->status->id == 11 )
            <p>{{ $candidatura->status->titulo }}</p>
            <button type="submit" data-toggle="modal" data-target="#editalModal"  class="btn btn-primary btn-sm">
              {{ __('Recurso') }}
            </button>
          @elseif( $candidatura->status->id == 12 )
            <p>{{ $candidatura->status->titulo }}</p>

            @isset($recurso->candidato->nome)
            <div class="card">
                <div class="card-body" style="background-color:powderblue;">
                  <h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
                  <p>
                    {{ $recurso->description }}
                  </p>
                </div>
            </div>
            @endif

            @isset($resposta->description)
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Aeri</h4>
                  <p>
                    {{ $resposta->description }}
                  </p>
                </div>
            </div>
            @endif
          @elseif( $candidatura->status->id == 13 )
            <p>{{ $candidatura->status->titulo }}</p>

             @isset($recurso->candidato->nome) 
             <div class="card">
                <div class="card-body" style="background-color:powderblue;">
                  <h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
                  <p>
                    {{ $recurso->description }}
                  </p>
                </div>
            </div>
            @endif

            @isset($resposta->description)
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Aeri</h4>
                  <p>
                    {{ $resposta->description }}
                  </p>
                </div>
            </div>
            @endif
          @elseif( $candidatura->status->id == 14 )
            <p>{{ $candidatura->status->titulo }}</p>
          @elseif( $candidatura->status->id == 15 )
           <p>{{ $candidatura->status->titulo }}</p>
           @elseif( $candidatura->status->id == 16 )
           <p>{{ $candidatura->status->titulo }}</p>  
          @endif

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