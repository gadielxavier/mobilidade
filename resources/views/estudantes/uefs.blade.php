@extends('layouts.site')

@section('content')

<div class="container-fluid">
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

	<form class="form-prevent-multiple-submits" method="get" action="{{ route('estudantes.uefs') }}">
		<div class="row">
	        <div class="col-sm-4">
	            <div class="form-group">
	                <label for="filtro-curso">Cursos</label>
	                <select id="filtro-curso" name="filtro-curso" class="form-control">
	                    <option value=""></option>
	                    @foreach($cursos as $curso)
	                        <option value="{{ $curso->nome }}">
	                            {{ $curso->nome }}
	                        </option>
	                    @endforeach
	                </select>
	            </div>
	        </div>
	        <div class="col-sm-2">
	            <div class="form-group">
	                <label for="filtro-programa">Programas</label>
	                <select id="filtro-programa" name="filtro-programa" class="form-control">
	                	<option value=""></option>
	                    @foreach($programas as $programa)
	                        <option value="{{ $programa->nome }}">
	                            {{ $programa->nome }}
	                        </option>
	                    @endforeach
	                </select>
	            </div>
	        </div>
	        <div class="col-sm-2">
	            <div class="form-group">
	                <label>&nbsp;</label>
	                <button type="submit" class="btn btn-block btn-success"><i class="fa fa-search"></i> Buscar</button>
	            </div>
	        </div>
	    </div>
	</form>

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>
              	<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								 <th>Nome</th>
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
							        		@if(strlen($estudante->candidato->nome) > 30 )
								          		<label data-toggle="tooltip" title="{{ $estudante->candidato->nome  }}">{{ substr($estudante->candidato->nome,0,30).('...')}}</label>
					                            
					                         @else
					                            {{ $estudante->candidato->nome }}
					                         @endif	
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->candidato->curso)
							        		@if(strlen($estudante->candidato->curso) > 28 )
								          		<label data-toggle="tooltip" title="{{ $estudante->candidato->curso  }}">{{ substr($estudante->candidato->curso,0,28).('...')}}</label>
					                            
					                         @else
					                            {{ $estudante->candidato->curso }}
					                         @endif	
				                        	
				                    	@endif
							        	</td> 
							        	<td>
							        	@isset($estudante->ies_anfitria)
							        		@if(strlen($estudante->ies_anfitria) > 30 )
								          		<label data-toggle="tooltip" title="{{ $estudante->ies_anfitria  }}">{{ substr($estudante->ies_anfitria,0,30).('...')}}</label>
					                            
					                         @else
					                            {{ $estudante->ies_anfitria }}
					                         @endif	
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
													<form class="form-prevent-multiple-submits" method="POST" action="{{ route('estudantes.updateUefs', $estudante->id) }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group{{ $errors->has('programa') ? ' has-error' : '' }}">
															<label>Programa</label>
															<div class="input-group">
																<select name="programa" class="form-control">
												              		@foreach($programas as $programa)
													                	@if($programa->nome == $estudante->edital->nome)
													                		<option selected value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
													                    @else
													                		<option value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
													                	@endif
												                    @endforeach
										               			 </select>
															</div>
														</div>
														<div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
															<label>Número</label>
															<div class="input-group">
																<input type="text" placeholder="Número do Edital" class="form-control" value="{{ $estudante->edital->numero }}" name="numero" required>
															</div>
														</div>
														<div class="form-group{{ $errors->has('data_edital') ? ' has-error' : '' }}">
															<label>Data do Edital</label>
															<div class="input-group">
																<input value="{{ $estudante->edital->inicio_inscricao->format('Y-m-d') }}" type="date" class="form-control" name="data_edital" required>
															</div>
														</div>
														<div class="form-group{{ $errors->has('aluno') ? ' has-error' : '' }}">
															<label>Aluno</label>
															<div class="input-group">
																<input type="text" placeholder="Nome do Aluno" value="{{ $estudante->candidato->nome }}" class="form-control" name="aluno" required>
															</div>
														</div>
														<div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
															<label>Sexo</label>
															<div class="input-group">
																<select id="sexo" name="sexo" class="form-control">
											                    	<option value="Masculino" @if($estudante->candidato->sexo == 'Masculino') {{'selected'}} @endif >Masculino</option>
												                    <option value="Feminino" @if($estudante->candidato->sexo == 'Feminino') {{'selected'}} @endif>Feminino</option>
												                    <option value="Outro" @if($estudante->candidato->sexo == 'Outro') {{'selected'}} @endif>Outro</option>
												                </select>
															</div>
														</div>
														<div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
															<label>Matrícula</label>
															<div class="input-group">
																<input type="text" placeholder="Matrícula do Aluno" class="form-control" value="{{ $estudante->candidato->matricula }}" name="matricula" id="Atualizaratricula" required>
															</div>
														</div>
														<div class="form-group{{ $errors->has('curso') ? ' has-error' : '' }}">
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
														<div class="form-group{{ $errors->has('universidade') ? ' has-error' : '' }}">
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
														<div class="form-group{{ $errors->has('cotista') ? ' has-error' : '' }}">
												          <label>Cotista</label>
												          <div class="input-group">
												            <div class="col-3">
												              <div class="form-check">
												                <label class="form-check-label" for="cotista1">
												                	<input class="form-check-input" type="radio" name="cotista" id="cotista1" value="1" @if($estudante->candidato->cotista == '1') {{'checked'}} @endif>
												                  	Sim
												                </label>
												              </div>
												          	</div>
												          	<div class="col-3">
												              <div class="form-check">
												                <label class="form-check-label" for="cotista2">
												                	<input class="form-check-input" type="radio" name="cotista" id="cotista2" value="0" @if($estudante->candidato->cotista == '0') {{'checked'}} @endif>
												                  	Não
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
					<div class="form-group{{ $errors->has('programa') ? ' has-error' : '' }}">
						<label>Programa</label>
						<div class="input-group">
							<select name="programa" class="form-control">
			                    @foreach($programas as $programa)
			                      <option value='{{ $programa->nome }}' @if( old('programa') == $programa->nome) {{'selected'}} @endif>{{ $programa->nome }}</option>
			                    @endforeach
	               			 </select>
	               			@if ($errors->has('programa'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('programa') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
						<label>Número</label>
						<div class="input-group">
							<input type="text" placeholder="Número do Edital" class="form-control" name="numero" value="{{ old('numero') }}"  required>
						</div>
						@if ($errors->has('numero'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('numero') }}</strong>
			                </span>
			            @endif
					</div>
					<div class="form-group{{ $errors->has('data_edital') ? ' has-error' : '' }}">
						<label>Data do Edital</label>
						<div class="input-group">
							<input type="date" class="form-control" name="data_edital" value="{{ old('data_edital') }}"  required>
						</div>
						@if ($errors->has('data_edital'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('data_edital') }}</strong>
			                </span>
			            @endif
					</div>
					<div class="form-group{{ $errors->has('aluno') ? ' has-error' : '' }}">
						<label>Aluno</label>
						<div class="input-group">
							<input type="text" placeholder="Nome do Aluno" class="form-control" name="aluno" value="{{ old('aluno') }}"  required>
						</div>
						@if ($errors->has('aluno'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('aluno') }}</strong>
			                </span>
			            @endif
					</div>
					<div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
						<label>Sexo</label>
						<div class="input-group">
							<select id="sexo" name="sexo" class="form-control">
			                    <option value="Masculino" @if( old('sexo') == 'Masculino') {{'selected'}} @endif>Masculino</option>
				                <option value="Feminino" @if( old('sexo') == 'Feminino') {{'selected'}} @endif>Feminino</option>
				                <option value="Outro" @if( old('sexo') == 'Outro') {{'selected'}} @endif>Outro</option>
			                </select>
						</div>
						@if ($errors->has('sexo'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('sexo') }}</strong>
			                </span>
			            @endif
					</div>
					<div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
						<label>Matrícula</label>
						<div class="input-group">
							<input type="text" placeholder="Matrícula do Aluno" class="form-control" name="matricula" id="AdicionarMatricula" value="{{ old('matricula') }}"  required>
						</div>
						@if ($errors->has('matricula'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('matricula') }}</strong>
			                </span>
			            @endif
					</div>
					<div class="form-group{{ $errors->has('curso') ? ' has-error' : '' }}">
						<label>Curso</label>
						<div class="input-group">
							<select id="curso" name="curso" class="form-control">
		                    	@foreach($cursos as $curso)
		                        	<option value="{{ $curso->nome }}" @if( old('curso') == $curso->nome) {{'selected'}} @endif>{{ $curso->nome }}</option>
		                    	@endforeach
			              	</select>
			              	@if ($errors->has('curso'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('curso') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('cotista') ? ' has-error' : '' }}">
			          <label>Cotista</label>
			          <div class="input-group">
			            <div class="col-3">
			              <div class="form-check">
			                <label class="form-check-label" for="cotista1">
			                	<input class="form-check-input" type="radio" name="cotista" id="cotista1" value="1">
			                  	Sim
			                </label>
			              </div>
			          	</div>
			          	<div class="col-3">
			              <div class="form-check">
			                <label class="form-check-label" for="cotista2">
			                	<input class="form-check-input" type="radio" name="cotista" id="cotista2" value="0" checked>
			                  	Não
			                </label>
			              </div>
			            </div>
			          </div>
			          @if ($errors->has('cotista'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('cotista') }}</strong>
		              	</span>
		              @endif
			        </div>
					<div class="form-group">
						<label>Universidade de Destino</label>
						<div class="input-group">
							<select name="universidade" class="form-control">
		                    @foreach($convenios as $convenio)
		                      <option value='{{ $convenio->universidade }}' @if( old('universidade') == $convenio->universidade) {{'selected'}} @endif>{{ $convenio->universidade." (".$convenio->pais.") "}}</option>
		                    @endforeach
		                  </select>
						</div>
						@if ($errors->has('universidade'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('universidade') }}</strong>
			                </span>
			            @endif
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<script>
  $(document).ready(function () { 
      var $matricula = $("#Atualizaratricula");
       $matricula.mask('99999999');
  });
  $(document).ready(function () { 
      var $matricula = $("#AdicionarMatricula");
       $matricula.mask('99999999');
  });
</script>

<script src="js/submit.js"></script>

<script type="text/javascript">
	@if (count($errors) > 0)
	$('#estudanteModal ').modal('show');
	@endif
</script>

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@endsection
