@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      	<div class="d-flex justify-content-between align-items-center">
	        	<div>
	          		<h4 class="font-weight-bold mb-0">Estudantes Uefs</h4>
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
								 <th>Matrícula</th>
								 <th>Curso</th>
								 <th>Universidade</th>
							</tr>
				    	</thead>
					    <tbody>
					    	<div class="scrolling-pagination">
						      	@foreach ($estudantes as $estudante)
							      	<tr>
							        	<td>
							        	@isset($estudante->candidato->nome)
				                        	{{ $estudante->candidato->nome }}
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->candidato->matricula)
				                        	{{ $estudante->candidato->matricula }}
				                    	@endif
							        	</td>
							        	<td>
							        	@isset($estudante->candidato->curso)
				                        	{{ $estudante->candidato->curso }}
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->ies_anfitria)
				                        	{{ $estudante->ies_anfitria }}
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
													<form class="form-horizontal" method="POST" action="{{ route('estudantes.updateUefs', $estudante->id) }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group">
															<label>Aluno</label>
															<div class="input-group">
																<input type="text" placeholder="Nome do Aluno" value="{{ $estudante->candidato->nome }}" class="form-control" name="aluno">
															</div>
														</div>
														<div class="form-group">
															<label>Sexo</label>
															<div class="input-group">
																<select id="sexo" name="sexo" class="form-control">
																	@if($estudante->candidato->sexo == 'Masculino')
												                    	<option selected value="Masculino">Masculino</option>
												                    @else
												                    	<option value="Masculino">Masculino</option>
												                    @endif
												                    @if($estudante->candidato->sexo == 'Feminino')
												                    	<option selected value="Feminino">Feminino</option>
												                    @else
												                    	<option value="Feminino">Feminino</option>
												                    @endif
												                    @if($estudante->candidato->sexo == 'Outro')
												                    	<option selected value="Masculino">Outro</option>
												                    @else
												                    	<option value="Outro">Masculino</option>
												                    @endif
												                </select>
															</div>
														</div>
														<div class="form-group">
															<label>Matrícula</label>
															<div class="input-group">
																<input type="text" placeholder="Matrícula do Aluno" class="form-control" value="{{ $estudante->candidato->matricula }}" name="matricula">
															</div>
														</div>
														<div class="form-group">
															<label>Curso</label>
															<div class="input-group">
																<select id="curso" name="curso" class="form-control">
											                    	@foreach($cursos as $curso)
											                    		@if($estudante->candidato->curso == $curso->nome)
											                        		<option selected value="{{ $curso->nome }}">{{ $curso->nome }}</option>
											                        	@else
											                        		<option value="{{ $curso->nome }}">{{ $curso->nome }}</option>
											                        	@endif
											                    	@endforeach
												              	</select>
															</div>
														</div>
														<div class="form-group">
															<label>Universidade</label>
															<div class="input-group">
																<select name="universidade" class="form-control">
											                    @foreach($convenios as $convenio)
											                    	@if($estudante->ies_anfitria == $convenio->universidade)
											                    		<option selected value='{{ $convenio->universidade }}'>{{ $convenio->universidade." (".$convenio->pais.") "}}</option>
											                    	@else
											                    		<option value='{{ $convenio->universidade }}'>{{ $convenio->universidade." (".$convenio->pais.") "}}</option>
											                    	@endif
											                    @endforeach
											                  </select>
															</div>
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
				<h5 class="modal-title" id="estudanteModalLabel">Adicionar estudante Uefs</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="addEstudanteUefs" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Programa</label>
						<div class="input-group">
							<select name="programa" class="form-control">
			                    @foreach($programas as $programa)
			                      <option value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
			                    @endforeach
	               			 </select>
						</div>
					</div>
					<div class="form-group">
						<label>Número</label>
						<div class="input-group">
							<input type="text" placeholder="Número do Edital" class="form-control" name="numero">
						</div>
					</div>
					<div class="form-group">
						<label>Data do Edital</label>
						<div class="input-group">
							<input type="date" class="form-control" name="data_edital">
						</div>
					</div>
					<div class="form-group">
						<label>Aluno</label>
						<div class="input-group">
							<input type="text" placeholder="Nome do Aluno" class="form-control" name="aluno">
						</div>
					</div>
					<div class="form-group">
						<label>Sexo</label>
						<div class="input-group">
							<select id="sexo" name="sexo" class="form-control">
			                    <option value="Masculino">Masculino</option>
			                    <option value="Feminino">Feminino</option>
			                    <option value="Outro">Outro</option>
			                </select>
						</div>
					</div>
					<div class="form-group">
						<label>Matrícula</label>
						<div class="input-group">
							<input type="text" placeholder="Matrícula do Aluno" class="form-control" name="matricula">
						</div>
					</div>
					<div class="form-group">
						<label>Curso</label>
						<div class="input-group">
							<select id="curso" name="curso" class="form-control">
		                    	@foreach($cursos as $curso)
		                        	<option value="{{ $curso->nome }}">{{ $curso->nome }}</option>
		                    	@endforeach
			              	</select>
						</div>
					</div>
					<div class="form-group">
						<label>Universidade</label>
						<div class="input-group">
							<select name="universidade" class="form-control">
		                    @foreach($convenios as $convenio)
		                      <option value='{{ $convenio->universidade }}'>{{ $convenio->universidade." (".$convenio->pais.") "}}</option>
		                    @endforeach
		                  </select>
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
