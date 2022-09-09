@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      	<div class="d-flex justify-content-between align-items-center">
	        	<div>
	          		<h4 class="font-weight-bold mb-0">{{ $edital->status->titulo }}</h4>
	        	</div>
	      		<div>
	      			<button type="submit" data-toggle="modal" data-target="#exportarPdfModal" class="btn btn-primary btn-icon-text btn-rounded">
                		<i class="ti-clipboard btn-icon-prepend"></i>
                		Exportar PDF
            		</button>
	      		</div>
	      	</div>
	    </div>
	</div>

	@if(session()->has('message'))
	    <div class="alert alert-success alert-dismissible fade show">
	        {{ session()->get('message') }}
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			</button>ß
	    </div>
	@endif

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive"> 
					@if($edital->status->id > 9)
						<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('resultado.segundafase', $edital->id) }}" enctype="multipart/form-data">
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
							      			{{ __('Atualizar') }}
							    		</button>
							  		</div>
								</div>
							</div>
				        </form>
				    @elseif($edital->status->id == 9)
						<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('resultado.update', $edital->id) }}" enctype="multipart/form-data">
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
							      			{{ __('Atualizar') }}
							    		</button>
							  		</div>
								</div>
							</div>
				        </form>
					@else
			            <table class="table table-striped">
			            	<thead>
								<tr>
									<th>Nome</th>
									<th>Matrícula</th>
									<th>Status</th>
								</tr>
					    	</thead>
					    	<tbody>
						    	@foreach ($candidaturas as $candidatura)
							     	<tr>
							    		<td>
							          	@isset($candidatura->candidato->nome)
							            	{{ $candidatura->candidato->nome }}
							          	@endif
							          	</td>
							          	<td>
							          	@isset($candidatura->candidato->matricula)
							            	{{ $candidatura->candidato->matricula }}
							          	@endif
							          	</td>
							          	<td>
							            @isset($candidatura->status->titulo)
							            	{{ $candidatura->status->titulo }}
							            @endif
							        	</td>
							      	</tr>
						      	@endforeach
						    </tbody>
						</table>
			        @endif
			    	</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal-->
<div class="modal fade" id="exportarPdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Instruções para próxima etapa</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('resultado.pdf', $edital->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="assinatura" class="col-form-label">Assinatura:</label>
						<input type="text" value="{{ $assessor->name }}" class="form-control" name="assinatura" id="assinatura"></input>
					</div>
					<div class="form-group">
						<label for="cargo" class="col-form-label">Cargo:</label>
						<input type="text" value="Assessor(a) Especial de Relações Institucionais" class="form-control" name="cargo" id="cargo"></input>
					</div>
					<div class="form-group">
						<label for="instrucoes" class="col-form-label">Mensagem:</label>
						<textarea class="form-control" rows="5" name="instrucoes" id="instrucoes"></textarea>
					</div>
					<div class="form-group">
			          <label>Alocar Universidades:</label>
			          <div class="input-group">
			          	@if($editalAeri->nome == $edital->nome)
			            <div class="col-4">
			              <div class="form-check">
			                <label class="form-check-label" for="alocar1">
			                	<input class="form-check-input" type="radio" name="alocar" id="alocar1" value="1">
			                  	Automaticamente
			                </label>
			              </div>
			          	</div>
			          	@endif
			          	<div class="col-4">
			              <div class="form-check">
			                <label class="form-check-label" for="alocar2">
			                	<input class="form-check-input" type="radio" name="alocar" id="alocar2" value="0" checked>
			                  	Manualmente
			                </label>
			              </div>
			            </div>
			          </div>
			        </div>
			        <div class="modal-footer">
				        <div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				              <button type="submit" class="btn btn-primary ml-auto">
				                {{ __('Exportar') }}
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

