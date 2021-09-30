@extends('layouts.site')

@section('content')

<div class="container-fluid">
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

	<form method="get" action="{{ route('estudantes.internacionais') }}">
		<div class="row">
	        <div class="col-sm-4">
	            <div class="form-group">
	                <label for="filtro-pais">Países</label>
	                <select id="filtro-pais" name="filtro-pais" class="form-control">
	                    <option value=""></option>
	                    @foreach($paises as $pais)
	                        <option value="{{ $pais->pais_nome }}">
	                            {{ $pais->pais_nome }}
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
														<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}" id="NomeFormGroup_{{$estudante->id}}">
												          <label>Nome</label>
												          <div class="input-group">
												            <div class="input-group-prepend bg-transparent">
												            </div>
												            <input value="{{$estudante->nome}}" id="nome" name="nome" type="text" class="form-control" placeholder="Nome do estudante" required>
												          </div>
												        </div>
												        <div class="form-group" id="SexoFormGroup_{{$estudante->id}}">
															<label>Sexo</label>
															<div class="input-group">
																<select id="sexo" name="sexo" class="form-control">
											                    	<option value="Masculino" @if($estudante->sexo == 'Masculino') {{'selected'}} @endif >Masculino</option>
												                    <option value="Feminino" @if($estudante->sexo == 'Feminino') {{'selected'}} @endif>Feminino</option>
												                    <option value="Outro" @if($estudante->sexo == 'Outro') {{'selected'}} @endif>Outro</option>
												                </select>
															</div>
														</div>
												        <div class="form-group{{ $errors->has('pais') ? ' has-error' : '' }}" id="PaisFormGroup_{{$estudante->id}}">
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
												        <div class="form-group{{ $errors->has('programa') ? ' has-error' : '' }}" id="ProgramaFormGroup_{{$estudante->id}}">
												          	<label>Programa</label>
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
												        <div class="form-group{{ $errors->has('modalidade') ? ' has-error' : '' }}" id="ModalidadeFormGroup_{{$estudante->id}}">
												          	<label>Modalidade</label>
												          	<select name="modalidade" id="modalidade_{{ $estudante->id }}" class="form-control" required>
												          		@if($estudante->modalidade == 'Graduação')
											                     	<option selected value='Graduação'>Graduação</option>
											                    @else
											                    	<option  value='Graduação'>Graduação</option>
											                    @endif
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
											                    @if($estudante->modalidade == 'Extensão')
											                    	<option selected value='Extensão'>Extensão</option>
											                    @else
											                    	<option value='Extensão'>Extensão</option>
											                    @endif
									               			</select>
												        </div>
												        <div class="form-group" id="InicioFormGroup_{{$estudante->id}}">
											                <label>Início</label>
											                <input type="date" value="{{ $estudante->inicio }}" id="inicio" name="inicio" class="form-control" required>
											            </div>
											            <div class="form-group" id="FinalFormGroup_{{$estudante->id}}">
											                <label>Final</label>
											                <input type="date" value="{{ $estudante->final }}" id="final" name="final" class="form-control" required>
											            </div>
											            <div class="form-group" id="auth-rows_{{ $estudante->id }}" style="display: none;">
											            	<div class="dropdown">
																<label>Vínculo</label>
																<select name="vinculo" id="vinculo_{{ $estudante->id }}" class="form-control custom-select" required>
																	<option value="{{ $estudante->vinculo }}" selected>{{ $estudante->vinculo }}</option>
																               
																</select>
															</div>
														</div>
												        <div class="modal-footer">
													        <div class="mt-3">
													        	<div class="form-group">
													            	<div class="input-group">
													            		<button type="button" class="btn btn-success" id="add_{{ $estudante->id }}" onclick="myFunction({!! $estudante->id !!})">Próximo</button>

													            		<button type="button" id="voltar_{{ $estudante->id }}" class="btn btn-success mr-2" onclick="voltarFunction({!! $estudante->id !!})" style="display:none;">
														                	{{ __('Voltar') }}
														                </button>

													              		<button type="submit" class="btn btn-primary ml-auto" style="display: none;" id="gerar_{{ $estudante->id }}">
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
				<h5 class="modal-title" id="estudanteModalLabel">Adicionar Estudante Internacional</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="addEstudanteInternacional" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group" id="NomeFormGroup">
						<label>Nome</label>
						<div class="input-group">
							<input type="text" placeholder="Nome do Aluno" class="form-control" name="nome" required>
						</div>
					</div>
					<div class="form-group" id="SexoFormGroup">
						<label>Sexo</label>
						<div class="input-group">
							<select id="sexo" name="sexo" class="form-control">
			                    <option value="Masculino">Masculino</option>
			                    <option value="Feminino">Feminino</option>
			                    <option value="Outro">Outro</option>
			                </select>
						</div>
					</div>
					<div class="form-group" id="PaisFormGroup">
						<label>País</label>
						<div class="input-group">
							<select name="pais" class="form-control" required>
		                    @foreach($paises as $pais)
		                      <option value='{{ $pais->pais_nome }}'>{{ $pais->pais_nome }}</option>
		                    @endforeach
		                  </select>
						</div>
					</div>
					<div class="form-group" id="ProgramaFormGroup">
						<label>Programa</label>
						<div class="input-group">
							<select name="programa" class="form-control" required>
			                    @foreach($programas as $programa)
			                      <option value='{{ $programa->nome }}'>{{ $programa->nome }}</option>
			                    @endforeach
	               			 </select>
						</div>
					</div>
					<div class="form-group" id="ModalidadeFormGroup">
						<label>Modalidade</label>
						<div class="input-group">
							<select name="modalidade" id="modalidade" class="form-control" required>
			                      <option value='Graduação'>Graduação</option>
			                      <option value='Mestrado'>Mestrado</option>
			                      <option value='Doutorado'>Doutorado</option>
			                      <option value='Extensão'>Extensão</option>
	               			 </select>
						</div>
					</div>
					<div class="form-group" id="InicioFormGroup">
						<label>Início</label>
						<div class="input-group">
							<input type="date" class="form-control" name="inicio">
						</div>
					</div>
					<div class="form-group" id="FinalFormGroup">
						<label>Final</label>
						<div class="input-group">
							<input type="date" class="form-control" name="final">
						</div>
					</div>
					<div class="form-group" id="auth-rows">

						
					</div>
					<div class="modal-footer">
				        <div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				            	<button  type="button" name="add" id="add" class="btn btn-success">Próximo</button>

				            	<button type="button" id="voltar" class="btn btn-success mr-2" style="display:none;">
				                	{{ __('Voltar') }}
				                </button>

				              	<button type="submit" id="gerar" class="btn btn-primary ml-auto" style="display:none;">
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

<script>
$(document).ready(function(){

	function cursos_dynamic_field()
	{
		html = '<div class="dropdown" id="dropdown">';
		html += '<label>Vínculo</label><select name="vinculo" id="vinculo" class="form-control custom-select" required>'
		                  +"@foreach($cursos as $curso)"
		                      +"<option value='{{ $curso->nome }}'>{{ $curso->nome }}</option>"
		                  +"@endforeach"
		    	+'</select>';
		html += '</div>';

		$('#auth-rows').append(html);
	    
	}

	function departamentos_dynamic_field()
	{
		html = '<div class="dropdown" id="dropdown">';
		html += '<label>Vínculo</label><select name="vinculo" id="vinculo" class="form-control custom-select" required>'
		                  +"@foreach($departamentos as $departamento)"
		                      +"<option value='{{ $departamento->nome }}'>{{ $departamento->nome }}</option>"
		                  +"@endforeach"
		    	+'</select>';
		html += '</div>';

		$('#auth-rows').append(html);
	    
	}

	function pos_dynamic_field()
	{
		html = '<div class="dropdown" id="dropdown">';
		html += '<label>Vínculo</label><select name="vinculo" id="vinculo" class="form-control custom-select" required>'
		                  +"@foreach($posGraduacoes as $pos)"
		                      +"<option value='{{ $pos->nome }}'>{{ $pos->nome.' ('.$pos->codigo.')'   }}</option>"
		                  +"@endforeach"
		    	+'</select>';
		html += '</div>';

		$('#auth-rows').append(html);
	    
	}

	$(document).on('click', '#add', function(){
		if(	document.getElementById("modalidade").value == "Graduação"){
			cursos_dynamic_field();
		}
		else if(document.getElementById("modalidade").value == "Mestrado" ||
		document.getElementById("modalidade").value == "Doutorado"  ){
			pos_dynamic_field();
		}
		else{
			departamentos_dynamic_field();
		}

		document.getElementById("add").style.display = "none";
		document.getElementById("NomeFormGroup").style.display = "none";
		document.getElementById("SexoFormGroup").style.display = "none";
		document.getElementById("PaisFormGroup").style.display = "none";
		document.getElementById("ProgramaFormGroup").style.display = "none";
		document.getElementById("ModalidadeFormGroup").style.display = "none";
		document.getElementById("InicioFormGroup").style.display = "none";
		document.getElementById("FinalFormGroup").style.display = "none";

		document.getElementById("gerar").style.display = "block";
		document.getElementById("voltar").style.display = "block";
	});

	$(document).on('click', '#voltar', function(){
		$('#dropdown').remove();
		document.getElementById("add").style.display = "block";
		document.getElementById("NomeFormGroup").style.display = "block";
		document.getElementById("SexoFormGroup").style.display = "block";
		document.getElementById("PaisFormGroup").style.display = "block";
		document.getElementById("ProgramaFormGroup").style.display = "block";
		document.getElementById("ModalidadeFormGroup").style.display = "block";
		document.getElementById("InicioFormGroup").style.display = "block";
		document.getElementById("FinalFormGroup").style.display = "block";

		document.getElementById("voltar").style.display = "none";
		document.getElementById("gerar").style.display = "none";
	});
});
</script>

<script>

	function cursos_dynamic_fieldId(index)
	{
		html = "@foreach($cursos as $curso)"
		        +"<option value='{{ $curso->nome }}'>{{ $curso->nome }}</option>"
		        +"@endforeach";

		$('#vinculo_'+index).append(html);
	    
	}

	function departamentos_dynamic_fieldId(index)
	{
		html = "@foreach($departamentos as $departamento)"
		        +"<option value='{{ $departamento->nome }}'>{{ $departamento->nome }}</option>"
		        +"@endforeach";

		$('#vinculo_'+index).append(html);
	    
	}

	function pos_dynamic_fieldId(index)
	{
		html = "@foreach($posGraduacoes as $pos)"
		        +"<option value='{{ $pos->nome }}'>{{ $pos->nome.' ('.$pos->codigo.')'   }}</option>"
		        +"@endforeach";

		$('#vinculo_'+index).append(html);
	}

	function myFunction(index) {
	  
		if(	document.getElementById("modalidade_"+index).value == "Graduação"){
			cursos_dynamic_fieldId(index);
		}
		else if(document.getElementById("modalidade_"+index).value == "Mestrado" ||
		document.getElementById("modalidade_"+index).value == "Doutorado"  ){
			pos_dynamic_fieldId(index);
		}
		else{
			departamentos_dynamic_fieldId(index);
		}

		document.getElementById("add_"+index).style.display = "none";
		document.getElementById("NomeFormGroup_"+index).style.display = "none";
		document.getElementById("SexoFormGroup_"+index).style.display = "none";
		document.getElementById("PaisFormGroup_"+index).style.display = "none";
		document.getElementById("ProgramaFormGroup_"+index).style.display = "none";
		document.getElementById("ModalidadeFormGroup_"+index).style.display = "none";
		document.getElementById("InicioFormGroup_"+index).style.display = "none";
		document.getElementById("FinalFormGroup_"+index).style.display = "none";

		document.getElementById("auth-rows_"+index).style.display = "block";
		document.getElementById("voltar_"+index).style.display = "block";
		document.getElementById("gerar_"+index).style.display = "block";
	}

	function voltarFunction(index) {

		var select = document.getElementById("vinculo_"+index);
		var length = select.options.length;
		for (i = length-1; i >= 1; i--) {
		  select.options[i] = null;
		}

		document.getElementById("add_"+index).style.display = "block";
		document.getElementById("NomeFormGroup_"+index).style.display = "block";
		document.getElementById("SexoFormGroup_"+index).style.display = "block";
		document.getElementById("PaisFormGroup_"+index).style.display = "block";
		document.getElementById("ProgramaFormGroup_"+index).style.display = "block";
		document.getElementById("ModalidadeFormGroup_"+index).style.display = "block";
		document.getElementById("InicioFormGroup_"+index).style.display = "block";
		document.getElementById("FinalFormGroup_"+index).style.display = "block";
		
		document.getElementById("auth-rows_"+index).style.display = "none";
		document.getElementById("voltar_"+index).style.display = "none";
		document.getElementById("gerar_"+index).style.display = "none";
	}

</script>

<script type="text/javascript">
	@if (count($errors) > 0)
	$('#estudanteModal ').modal('show');
	@endif
</script>

@endsection
