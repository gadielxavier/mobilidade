@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body table-responsive">
      		<h4 class="card-title">Resultado Parcial</h4>
      		<div class="d-flex justify-content-end mb-4">
	            <a class="btn btn-primary" href="{{ route('resultado.pdf', $edital->id) }}">Exportar PDF</a>
	        </div>
      		@if(session()->has('message'))
			    <div class="alert alert-success alert-dismissible fade show">
			        {{ session()->get('message') }}
			        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			    </div>
			@endif
			@if($edital->status->id > 9)
				<form method="POST" action="{{ route('resultado.segundafase', $edital->id) }}" enctype="multipart/form-data">
		            {{ csrf_field() }}
		            <table class="table table-striped">
		            	<thead>
							<tr>
								<th>#</th>
								<th>Nome</th>
								<th>Nota Final</th>
								<th>Ies Anfitriã</th>
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
						          	@isset($avaliacao->nota_final)
						            	{{ $avaliacao->nota_final }}
						            @endif
						        	</td>
						        	<td>
						            	<select id="universidades" name="universidades[]" class="form-control custom-select">
							                <option selected></option>
							                    @foreach($universidades as $universidade)
							                    	@if($universidade->nome == $avaliacao->candidatura->ies_anfitria)
							                    		<option selected value="{{ $universidade->nome }}">{{ $universidade->nome }}</option>
							                    	@else
							                    		<option value="{{  $universidade->nome }}">{{ $universidade->nome }}</option>
							                    	@endif
							                    @endforeach
							            </select>
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
			@else
				<form method="POST" action="{{ route('resultado.update', $edital->id) }}" enctype="multipart/form-data">
		            {{ csrf_field() }}
		            <table class="table table-striped">
		            	<thead>
							<tr>
								<th>#</th>
								<th>Nome</th>
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
						            @if($avaliacao->candidatura->carta == '0')
						            	<td>Carta de Recomendação não anexada</td>
							        	<td></td>
							        	<td></td>
						          	@elseif($avaliacao->finalizado)
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
							          	@isset($avaliacao->candidatura->desempenho)
							            	{{ $avaliacao->candidatura->desempenho }}
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
	        @endif
		</div>
	</div>

	@if($edital->status->id == 9)
	<div class="card">
		@php
			$count = 0;
		@endphp
		@foreach ($classificacoes[1] as $classificacao)
			<div class="card-body table-responsive">
				<h4 class="card-title">Resultado Parcial {{ $classificacoes[0][$count] }} </h4>
				<table class="table table-striped">
	            	<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
						</tr>
			    	</thead>
			    	@php
						$posicao = 1;
					@endphp
			    	<tbody>
						@foreach($classificacao as $candidatos)
							<tr>
								<td>{{ $posicao }}</td>
								<td>{{ $candidatos }}</td>
							</tr>
							@php
								$posicao++;
							@endphp
						@endforeach
					</tbody>
				</table>
			</div>
			@php
				$count++;
			@endphp
		@endforeach
	</div>
	@endif
</div>

@endsection

