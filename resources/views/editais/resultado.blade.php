@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body table-responsive">
      		<h4 class="card-title">Resultado Parcial</h4>
			<form method="POST" action="{{ route('resultado.update', $edital->id) }}" enctype="multipart/form-data">
	            {{ csrf_field() }}
	            <table class="table table-striped">
	            	<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Avaliador</th>
							<th>Plano de Trabalho</th>
							<th>Curriculum</th>
							<th>Carta</th>
							<th>Desempenho</th>
							<th>Nota Final</th>
						</tr>
			    	</thead>
			    	<tbody>
				    	@foreach ($avaliacoes as $avaliacao)
					     	<tr>
					     		<td>
					    			<input type="checkbox" value="{{ $avaliacao->id }}" style="display:none" name="avaliacoes[]" checked="checked" />

					          	@isset($avaliacao->id)
					            	{{ $avaliacao->posicao }}
					          	@endif
					          	</td>
					    		<td>
					          	@isset($avaliacao->id)
					            	{{ $avaliacao->candidatura->candidato->nome }}
					          	@endif
					          	</td>
					          	<td>
					          	@isset($avaliacao->id)
					            	{{ $avaliacao->avaliador->name }}
					            @endif
					            </td>
					          	@if($avaliacao->finalizado)
					          		<td>
						          	@isset($avaliacao->plano_trabalho)
						            	{{ $avaliacao->plano_trabalho }}
						            @endif
						            </td>
						            <td>
						          	@isset($avaliacao->curriculum_lattes)
						            	{{ $avaliacao->curriculum_lattes }}
						            @endif
						            </td>
						            <td>
						          	@isset($avaliacao->carta)
						            	{{ $avaliacao->carta }}
						            @endif
						            </td>
						        @else
						        	<td>Avaliação não finalizada</td>
						        	<td></td>
						        	<td></td>
					            @endif
					            	<td>
						          	@isset($avaliacao->desempenho_academico)
						            	<input type="text" name="desempenho[]" value="{{ $avaliacao->desempenho_academico }}" required>
						            @endif
						        	</td>
						        	<td>
						          	@isset($avaliacao->nota_final)
						            	{{ $avaliacao->nota_final }}
						            @endif
						        	</td>
					      	</tr>
				      	@endforeach
				    </tbody>
				</table>
				<div class="mt-3">
					<div class="form-group">
				  		<div class="input-group">
				    		<button type="submit" class="btn btn-primary ml-auto">
				      			{{ __('Atuaizar') }}
				    		</button>
				  		</div>
					</div>
				</div>
	        </form>
		</div>
	</div>
</div>

@endsection

