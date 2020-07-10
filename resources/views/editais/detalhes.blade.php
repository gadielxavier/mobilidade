@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<form method="POST" action="{{ route('editais.ccint') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="row">
		    <div class="col-md-12 grid-margin">
		      <div class="d-flex justify-content-between align-items-center">
		        <div>
		          <h4 class="font-weight-bold mb-0">Edital {{$edital->nome.' '.$edital->numero}}</h4>
		        </div>
		      </div>
		    </div>
		</div>

		<div class="card">
	    	<div class="card-body">
	    		<h4 class="card-title">Informações do Edital</h4>
	      			<div class="row table-responsive">
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
			             		<tr>
						        	<td>
						            	{{ $edital->nome }}
						            </td>
							        <td> 
							            {{ $edital->numero }}
							        </td>
							        <td>
							        	{{ $edital->qtd_bolsas }}
							        </td>
							        <td>
							        	{{ $edital->fim_inscricao->format('d/m/Y') }}
							        </td>
							        <td>
							          	<a href="/editais/atualizar/{{ $edital->id }}"  class="btn btn-primary btn-sm"> Editar</a>
							        </td>
							       	@if($edital->status->id == 3)
							        <td>
							          	<a href="/editais/resultado/{{ $edital->id }}"  class="btn btn-success btn-sm"> Resultado Parcial</a>
							        </td>
							        @endif
							        <!--
							        <td>
							          	<a href="#deleteModal_{{ $edital->id }}" data-toggle="modal" class="btn btn-danger btn-sm"> Excluir</a>

							          	<div id="deleteModal_{{ $edital->id }}" class="modal fade">
							          		<div class="modal-dialog">
							          			<div class="modal-content">
							          				<div class="modal-header">
							          					<h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
							          					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							          						<span aria-hidden="true">×</span>
							          					</button>
							          				</div>
							          				<div class="modal-body">
							          					<form class="form-horizontal" method="POST" action="delete/{{ $edital->id }}">
									                      {{ csrf_field() }}
									                      <input type="hidden" name="_method" value="DELETE">
									                      <h6>Você tem certeza que deseja excluir esta edital?</h6>

									                    	<div class="modal-footer">
									                      		<div class="form-group">
									                        		<button type="submit" class="btn btn-primary">
									                          			Sim
									                        		</button>
									                        		<button type="button" data-dismiss="modal" class="btn btn-outline-primary">
									                          			Não
									                        		</button>
									                      		</div>
									                    	</div>
									      				</form>
									      			</div>
									      		</div>
									      	</div>
									    </div>
									</td>
								-->
						      	</tr>
				             </tbody>
				         </table>
	      			</div>
	      	</div>
	     </div>

		<div class="card">
	    	<div class="card-body">
	      		<h4 class="card-title">Candidatos Inscritos</h4>
      			<div class="row table-responsive">
      				<table class="table table-striped">
      					<thead>
      						<tr>
      							<th></th>
      							<th>Nome</th>
			                    <th>Curso</th>
			                    <th>Situaçâo</th>
			                    <th></th>
			                 </tr>
			             </thead>
			             <tbody>
			             	@foreach ($candidaturas as $candidatura)

			             		<tr>
			             			<td>
										<input name="candidatura[]" type="checkbox" value="{{ $candidatura->id }}" id="candidatura">
			             			</td>
						        	<td>
						          		@isset($candidatura->candidato->nome)
										  <label class="form-check-label" for="defaultCheck1">
										    {{ $candidatura->candidato->nome }}
										  </label>
						          		@endif
						          	</td>
							        <td> 
							          	@isset($candidatura->candidato->curso)
							            	{{ $candidatura->candidato->curso }}
							          	@endif
							        </td>
							        <td>
							          	@isset($candidatura->status->titulo)
							            	{{ $candidatura->status->titulo }}
							          	@endif
							        </td>
							        <td>
							          	<a href="candidatura/{{ $candidatura->id }}"  class="btn btn-primary btn-sm"> Visualizar</a>
							        </td>
						      	</tr>
					      @endforeach
			             </tbody>
			         </table>
			         {{ $candidaturas->links("pagination::bootstrap-4") }}
      			</div>	
	      	</div>
	     </div>
	     <div class="card">
	     	<div class="card-body">
	     		<div class="row">
					<div class="col-md-5">
						<label>Status Inscrição:</label>
					    <div class="dropdown">
				    		<select id="status" name="status" class="form-control custom-select">
				                <option selected></option>
				                    @foreach($status as $estado)
				                    	<option value="{{  $estado->id }}">{{ $estado->titulo }}</option>
				                    @endforeach
				            </select>
				        </div>
				    </div>
				</div>
	     	</div>
	     </div>
	     
	     <div class="card">
	    	<div class="card-body">
	    		<div class="row">
	    			@if($edital->status->id == 3)
		                <div class="col-md-5">
		                	<label>Avaliador Ccint:</label>
				          	@isset($candidatura->status->titulo)
					          	<select id="avaliador" name="avaliador" class="form-control custom-select">
					          		<option selected></option>
								    @foreach($avaliadores as $avaliador)
				                    	<option value="{{  $avaliador->id }}">{{ $avaliador->name }}</option>
				                    @endforeach
								</select>
							@endif
		                </div>	
					@endif
		          </div>
		          <div class="mt-3">
			       	<div class="form-group">
			           <div class="input-group">
			             <button type="submit" class="btn btn-primary ml-auto">
			               {{ __('Atualizar') }}
			             </button>
			           </div>
			        </div>
			      </div>
	    	</div>
	    </div>
	</form>
</div>

@endsection