@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      	<div class="d-flex justify-content-between align-items-center">
	        	<div>
	          		<h4 class="font-weight-bold mb-0">Estudantes Internacionais</h4>
	        	</div>
	      		<div>
	      			<button type="submit" data-toggle="modal" data-target="#estudanteModal" class="btn btn-primary btn-icon-text btn-rounded">
                		<i class="ti-user btn-icon-prepend"></i>Adicionar Estudante
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
			</button>
	    </div>
	@endif

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <div class="card-body">

              	<div class="row table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								 <th>Nome</th>
								 <th>País</th>
								 <th>Programa</th>
								 <th>Modalidade</th>
							</tr>
				    	</thead>
					    <tbody>
					    	<div class="scrolling-pagination">
						      	@foreach ($estudantes as $estudante)
							      	<tr>
							        	<td>
							        	@isset($estudante->nome)
				                        	{{ $estudante->nome }}
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->pais)
				                        	{{ $estudante->pais }}
				                    	@endif
							        	</td>
							        	<td>
							        	@isset($estudante->programa)
				                        	{{ $estudante->programa }}
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->modalidade)
				                        	{{ $estudante->modalidade }}
				                    	@endif
							        	</td>  
							        	<td> 
							          		<button type="submit" data-toggle="modal" data-target="#editarModal_{{ $estudante->id }}"  class="btn btn-primary btn-sm"> Editar</button>
							        	</td>
							      	</tr>
							      	<!-- Editar Modal-->
									<div class="modal fade" id="editarModal_{{ $estudante->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Editar estudante</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" method="POST" action="{{ route('estudantes.updateInternacionais', $estudante->id) }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
												          <label>Nome</label>
												          <div class="input-group">
												            <div class="input-group-prepend bg-transparent">
												            </div>
												            <input value="{{$estudante->nome}}" id="nome" name="nome" type="text" class="form-control" placeholder="Nome do estudante" required>
												          </div>
												        </div>
												        <div class="form-group{{ $errors->has('pais') ? ' has-error' : '' }}">
												          	<label>País</label>
												          	<select name="pais" class="form-control" required>
												          		@foreach($paises as $pais)
												          			@if($pais->pais_nome == $estudante->pais)
												                		<option selected value='{{ $pais->pais_nome }}'>{{ $pais->pais_nome }}</option>
												                	@else
												                		<option value='{{ $pais->pais_nome }}'>{{ $pais->pais_nome }}</option>
												                	@endif
												          		@endforeach
								               			 	</select>
												        </div>
												        <div class="form-group{{ $errors->has('programa') ? ' has-error' : '' }}">
												          	<label>País</label>
												          	<select name="programa" class="form-control" required>
												          		@foreach($programas as $programa)
												          			@if($programa->nome == $estudante->programa)
												                		<option selected value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
												                	@else
												                		<option value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
												                	@endif
												          		@endforeach
								               			 	</select>
												        </div>
												        <div class="form-group{{ $errors->has('modalidade') ? ' has-error' : '' }}">
												          	<label>Modalidade</label>
												          	<select name="modalidade" class="form-control" required>
												          		@if($estudante->modalidade == 'Mestrado')
											                     	<option selected value='Mestrado'>Mestrado</option>
											                    @else
											                    	<option  value='Mestrado'>Mestrado</option>
											                    @endif
											                    @if($estudante->modalidade == 'Doutorado')
											                    	<option selected value='Doutorado'>Doutorado</option>
											                    @else
											                    	<option value='Doutorado'>Doutorado</option>
											                    @endif
											                    @if($estudante->modalidade == '√ß')
											                    	<option selected value='Curso de Português'>Curso de Português</option>
											                    @else
											                    	<option value='Curso de Português'>Curso de Português</option>
											                    @endif
									               			</select>
												        </div>
												        <div class="modal-footer">
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
													</form>
												</div>
											</div>
										</div>
									</div>
						      	@endforeach
						    </div>
					    </tbody>
				  	</table>
				  {{ $estudantes->links("pagination::bootstrap-4") }}
				</div>
              </div>
            </div>
          </div>
        </div>
	</div>
</div>

<!-- Modal Candidatura-->
<div class="modal fade" id="estudanteModal" tabindex="-1" role="dialog" aria-labelledby="estudanteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="estudanteModalLabel">Adicionar Estudante Internacional</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="addEstudanteInternacional" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Nome</label>
						<div class="input-group">
							<input type="text" placeholder="Nome do Aluno" class="form-control" name="nome" required>
						</div>
					</div>
					<div class="form-group">
						<label>País</label>
						<div class="input-group">
							<select name="pais" class="form-control" required>
		                    @foreach($paises as $pais)
		                      <option value='{{ $pais->pais_nome }}'>{{ $pais->pais_nome }}</option>
		                    @endforeach
		                  </select>
						</div>
					</div>
					<div class="form-group">
						<label>Programa</label>
						<div class="input-group">
							<select name="programa" class="form-control" required>
			                    @foreach($programas as $programa)
			                      <option value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
			                    @endforeach
	               			 </select>
						</div>
					</div>
					<div class="form-group">
						<label>Modalidade</label>
						<div class="input-group">
							<select name="modalidade" class="form-control" required>
			                      <option value='Mestrado'>Mestrado</option>
			                      <option value='Doutorado'>Doutorado</option>
			                      <option value='Curso de Português'>Curso de Português</option>
	               			 </select>
						</div>
					</div>
					<div class="form-group">
						<label>Início</label>
						<div class="input-group">
							<input type="date" class="form-control" name="inicio">
						</div>
					</div>
					<div class="form-group">
						<label>Final</label>
						<div class="input-group">
							<input type="date" class="form-control" name="final">
						</div>
					</div>
					<div class="modal-footer">
				        <div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				              	<button type="submit" id="gerar" class="btn btn-primary ml-auto">
				                	{{ __('Adicionar') }}
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

@section('scripts')

<script type="text/javascript">
	@if (count($errors) > 0)
	$('#estudanteModal ').modal('show');
	@endif
</script>

@endsection
