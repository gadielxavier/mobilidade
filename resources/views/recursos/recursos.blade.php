@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Recursos</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="card">
    	<div class="card-body">
      		<h4 class="card-title">Recursos abertos</h4>
      			<div class="row table-responsive">
      				@if(isset($recursos[0]))
      				<table class="table table-striped">
      					<thead>
      						<tr>
      							<th>Candidato</th>
			                     <th>Edital</th>
			                 </tr>
			             </thead>
			             <tbody>
			             	@foreach ($recursos as $recurso)

			             		<tr>
						        	<td>
						          		@isset($recurso->candidato->id)
						            		{{ $recurso->candidato->nome }}</td>
						          		@endif
							        <td> 
							          	@isset($recurso->edital->id)
							            	{{ $recurso->edital->nome.' '.$recurso->edital->numero }}
							          	@endif
							        </td>
							        <td>
							          	<a href="{{ route('recurso.detalhes', $recurso->id) }}"  class="btn btn-primary btn-sm"> Visualizar</a>
							        </td>
						      	</tr>
					      @endforeach
			             </tbody>
			         </table>
			         @else
			          <p>Não existe nenhum recurso aberto no momento!</p>
			         @endif
      			</div>
      	</div>
     </div>

     <div class="card">
    	<div class="card-body">
      		<h4 class="card-title">Recursos respondidos</h4>
      			<div class="row table-responsive">
      				@if(isset($recursosRespondidos[0]))
      				<table class="table table-striped">
      					<thead>
      						<tr>
      							<th>Candidato</th>
			                     <th>Edital</th>
			                 </tr>
			             </thead>
			             <tbody>
			             	@foreach ($recursosRespondidos as $recurso)

			             		<tr>
						        	<td>
						          		@isset($recurso->candidato->id)
						            		{{ $recurso->candidato->nome }}</td>
						          		@endif
							        <td> 
							          	@isset($recurso->edital->id)
							            	{{ $recurso->edital->nome.' '.$recurso->edital->numero }}
							          	@endif
							        </td>
							        <td>
							          	<a href="{{ route('recurso.detalhes', $recurso->id) }}"  class="btn btn-primary btn-sm"> Visualizar</a>
							        </td>
						      	</tr>
					      @endforeach
			             </tbody>
			         </table>
			         @else
			          <p>Não existe nenhum recurso respondido no momento!</p>
			         @endif
      			</div>
      	</div>
     </div>
</div>


@endsection