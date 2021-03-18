@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<form class="form-prevent-multiple-submits" method="POST" action="/ccint/store/{{ $candidatura->id }}" enctype="multipart/form-data" id="myForm">
		{!! csrf_field() !!}
		<div class="row">
		    <div class="col-md-12 grid-margin">
		      <div class="d-flex justify-content-between align-items-center">
		        <div>
		          <h4 class="font-weight-bold mb-0">Avaliação {{$candidatura->candidato->nome}}</h4>
		        </div>
		      </div>
		    </div>
		</div>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<div class="card">
	    	<div class="card-body">
	    		<label class="card-title">Plano de trabalho 1</label>
	          	<a  href="{{ route('ccint.trabalho1', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
                <br>
                <label class="card-title">Plano de trabalho 2</label>
	          	<a  href="{{ route('ccint.trabalho2', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
                <br>
                <label class="card-title">Plano de trabalho 3</label>
	          	<a  href="{{ route('ccint.trabalho3', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
                <br>
	          	<div class="form-group">
	            	<label>Estrutura do texto, contemplando os itens propostos (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              	</div>
	              	<input id="estrutura" name="estrutura" type="text" class="form-control" value="{{ old('estrutura') }}" required autofocus>
	              	@if ($errors->has('estrutura'))
                    <span class="help-block">
                      <strong>{{ $errors->first('estrutura') }}</strong>
                    </span>
                    @endif
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Objetividade (até 6,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="objetividade" name="objetividade" type="text" class="form-control" value="{{ old('objetividade') }}" required autofocus>
		              	@if ($errors->has('objetividade'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('objetividade') }}</strong>
	                    </span>
	                    @endif
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Clareza na escolha da IES e das disciplinas (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              	<input id="clareza" name="clareza" type="text" class="form-control" value="{{ old('clareza') }}" required autofocus>
	              	@if ($errors->has('clareza'))
                    <span class="help-block">
                      <strong>{{ $errors->first('clareza') }}</strong>
                    </span>
                    @endif
	            	</div>
	          	</div>
	      	</div>
	  	</div>
	  	<br>
	  	<div class="card">
	    	<div class="card-body">
				<label class="card-title">Currículo Lattes</label>
				<a  href="{{ route('ccint.curriculum', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
				@if(isset($arquivoParticipacoes[0]))
					<h5>Participações /Organizações em/de Reuniões/Eventos por área de formação (máx 10 pontos)</h5>
					<table class="table table-striped">
				  		<thead>
				    		<tr>
				       			<th>Categoria</th>
				    		</tr>
				  		</thead>
				  		<tbody>
					    	@foreach ($arquivoParticipacoes as $arquivo)
					        	<tr>
					          		<td>
					          			<div class="dropdown">
							                <select id="curso" name="curso" class="form-control custom-select">
							                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
							                    @foreach($comprovacoes as $comprovacao)
							                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
							                    @endforeach
							                </select>
							            </div>
					          		</td>
					          		<td>
					          			<a  href="{{ route('ccint.comprovacao', $arquivo->id) }}" target="_blank">
					                		Visualizar
					                	</a>
					          		</td>
					          	</tr>
					          	<tr>
					          		<td>
					          			<input id="participacao[]" name="participacao[]" type="text" class="form-control" value="{{ old('participacao[]') }}" required autofocus>
					          		</td>
					          		<td>
						            	@if ($errors->has('participacao'))
					                    <span class="help-block">
					                      <strong>{{ $errors->first('participacao') }}</strong>
					                    </span>
					                    @endif
					          		</td>
					        	</tr>
					    	@endforeach
					    </tbody>
					</table>
				@endif

				<br>
				@if(isset($arquivoIndicadores[0]))
					<h5>Indicadores de Produção Científica, Tecnológica e Artística</h5>
					<table class="table table-striped">
					  	<thead>
					    	<tr>
					       		<th>Categoria</th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		@foreach ($arquivoIndicadores as $arquivo)
						        <tr>
						          	<td>
						          		<div class="dropdown">
							                <select id="curso" name="curso" class="form-control custom-select">
							                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
							                    @foreach($comprovacoes as $comprovacao)
							                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
							                    @endforeach
							                </select>
								        </div>
						          	</td>
						          	<td>
					          			<a  href="{{ route('ccint.comprovacao', $arquivo->id) }}" target="_blank">
					                		Visualizar
					                	</a>
						          	</td>
						        </tr>
					          	<tr>
					          		<td>
					          			<input id="indicadores[]" name="indicadores[]" type="text" class="form-control" value="{{ old('indicadores[]') }}" required autofocus>
					          		</td>
					          		<td>
					            		@if ($errors->has('indicadores'))
				                    	<span class="help-block">
				                      		<strong>{{ $errors->first('indicadores') }}</strong>
				                    	</span>
				                    	@endif
				          			</td>
				        		</tr>
					    	@endforeach
						</tbody>
					</table>
				@endif
				   
				<br>   
				@if(isset($arquivoRepresentacao[0]))
					<h5>Representação/Liderança Estudantil em instâncias da Universidade (máx 10 pontos)</h5>
					<table class="table table-striped">
					  	<thead>
					    	<tr>
					       		<th>Categoria</th>
					    	</tr>
					  	</thead>
					  	<tbody>
					    	@foreach ($arquivoRepresentacao as $arquivo)
					        	<tr>
					          		<td>
					          			<div class="dropdown">
							                <select id="curso" name="curso" class="form-control custom-select">
							                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
							                    @foreach($comprovacoes as $comprovacao)
							                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
							                    @endforeach
							                </select>
							            </div>
					          		</td>
					          		<td>
					          			<a  href="{{ route('ccint.comprovacao', $arquivo->id) }}" target="_blank">
					                		Visualizar
					                	</a>
					          		</td>
					          	</tr>
					          	<tr>
					          		<td>
					          			<input id="representacao[]" name="representacao[]" type="text" class="form-control" value="{{ old('representacao[]') }}" required autofocus>
					          		</td>
					          		<td>
						      			@if ($errors->has('representacao'))
					                    <span class="help-block">
					                      <strong>{{ $errors->first('representacao') }}</strong>
					                    </span>
					                    @endif
					          		</td>
					        	</tr>
					    	@endforeach
					    </tbody>
					</table>
				@endif
				<br>   
				@if(isset($arquivoInstitucional[0]))
					<h5>Participação em Programa Acadêmico Institucional ou Estágios (máx 10 pontos)</h5>
					<table class="table table-striped">
				  		<thead>
				    		<tr>
				       			<th>Categoria</th>
				    		</tr>
				  		</thead>
				  		<tbody>
					    	@foreach ($arquivoInstitucional as $arquivo)
					        	<tr>
					          		<td>
					          			<div class="dropdown">
							                <select id="curso" name="curso" class="form-control custom-select">
							                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
							                    @foreach($comprovacoes as $comprovacao)
							                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
							                    @endforeach
							                </select>
							            </div>
					          		</td>
					          		<td>
					          			<a  href="{{ route('ccint.comprovacao', $arquivo->id) }}" target="_blank">
					                		Visualizar
					                	</a>
					          		</td>
					          	</tr>
					          	<tr>
					          		<td>
					          			<input id="institucional[]" name="institucional[]" type="text" class="form-control" value="{{ old('institucional[]') }}" required autofocus>
					          		</td>
					          		<td>
						            	@if ($errors->has('institucional'))
					                    <span class="help-block">
					                      <strong>{{ $errors->first('institucional') }}</strong>
					                    </span>
					                    @endif
					          		</td>
					        	</tr>
					    	@endforeach
				   		</tbody>
					</table>
				@endif
				<br> 
	      	</div>
	  	</div>
	  	<br>
	    <div class="card">
	    	<div class="card-body">
	    		<label class="card-title">Carta de Recomendação</label>
	          	<a  href="{{ route('ccint.carta', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
		        <div class="row">
				  <div class="col-md-6">
				  	<label>Capacidade de aprender novas idéias (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="ideias" id="ideias" value="{{ old('ideias') }}" required autofocus>
				        @if ($errors->has('ideias'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('ideias') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				  <div class="col-md-6">
				  	<label>Capacidade de trabalhar e persistência (até 5,0)</label>
				    <div class="form-group row"> 
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="persistencia" id="persistencia" value="{{ old('persistencia') }}">
				        @if ($errors->has('persistencia'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('persistencia') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-6">
				  	<label>Motivação, entusiasmo e interesse (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="interesse" value="{{ old('interesse') }}" id="interesse">
				        @if ($errors->has('interesse'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('interesse') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				  <div class="col-md-6">
				  	<label>Capacidade de resolver problema (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="problema" value="{{ old('problema') }}" id="problema">
				        @if ($errors->has('problema'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('problema') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-6">
				  	<label>Imaginação e criatividade (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="criatividade" value="{{ old('criatividade') }}" id="criatividade">
				        @if ($errors->has('criatividade'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('criatividade') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				  <div class="col-md-6">
				  	<label>Expressão escrita (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="escrita" value="{{ old('escrita') }}"  id="escrita">
				        @if ($errors->has('escrita'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('escrita') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-6">
				  	<label>Expressão oral (até 5,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input type="text" class="form-control" name="oral" value="{{ old('oral') }}" id="oral" >
				        @if ($errors->has('oral'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('oral') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				  <div class="col-md-6">
				  	<label>Informações adicionais fornecidas (até 2,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input id="adicionais" name="adicionais" type="text" class="form-control" value="{{ old('adicionais') }}" required autofocus>
	              		@if ($errors->has('adicionais'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('adicionais') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-6">
				  	<label>Mérito do candidato (até 3,0)</label>
				    <div class="form-group row">
				      <div class="col-sm-9">
				        <input id="merito" name="merito" type="text" class="form-control" value="{{ old('merito') }}" required autofocus>
	              		@if ($errors->has('merito'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('merito') }}</strong>
	                    </span>
	                    @endif
				      </div>
				    </div>
				  </div>
				</div>
	          	<div class="mt-3">
	            	<div class="form-group">
	              		<div class="input-group">
	                		<button type="button" class="btn btn-primary ml-auto" id="submitButton" data-toggle="modal" data-target="#confirm-submit-modal">
	                  			{{ __('Enviar') }}
	                		</button>
	              		</div>
	            	</div>
	          	</div>
      		</div>
     	</div>
     	<!------------------------------------------------------------------------------------->
		<div class="modal fade" id="confirm-submit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                Confirmar Envio
		            </div>
		            <div class="modal-body">
		            	<label class="card-title">Planos de trabalho</label>
		                <table class="table">
		                    <tr>
		                        <th>Estrutura do texto</th>
		                        <td id="estrutura_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Objetividade</th>
		                        <td id="objetividade_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Clareza</th>
		                        <td id="clareza_modal"></td>
		                    </tr>
		                </table>
		                <label class="card-title">Currículo Lattes</label>
		                <table class="table">
		                	<tr>
		                        <th>Participações</th>
		                        <td id="participacao_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Indicadores</th>
		                        <td id="indicadores_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Representação</th>
		                        <td id="representacao_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Institucional</th>
		                        <td id="institucional_modal"></td>
		                    </tr>
		                </table>
		                <label class="card-title">Carta de Recomendação</label>
		                <table class="table">
		                    <tr>
		                        <th>Ideias</th>
		                        <td id="ideias_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Persistência</th>
		                        <td id="persistencia_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Interesse</th>
		                        <td id="interesse_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Problema</th>
		                        <td id="problema_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Criatividade</th>
		                        <td id="criatividade_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Escrita</th>
		                        <td id="escrita_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Oral</th>
		                        <td id="oral_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Adicionais</th>
		                        <td id="adicionais_modal"></td>
		                    </tr>
		                    <tr>
		                        <th>Mérito</th>
		                        <td id="merito_modal"></td>
		                    </tr>
		                </table>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		                <button type="submit" class="btn btn-success success button-prevent-multiple-submits">Enviar</button>
		            </div>
		        </div>
		    </div>
		</div>
	</form>
</div>


@endsection

@section('scripts')

<script src="js/submit.js"></script>

<script type="text/javascript">
@if (count($errors) > 0){
    $('#confirm-submit-modal').modal({show: false});
}
@endif
</script>

<script>


	$('#submitButton').click(function() {

		var participacao_array = document.getElementsByName('participacao[]');
		var participacao = 0;

		for(key=0; key < participacao_array.length; key++)  {
		    participacao += parseInt(participacao_array[key].value);
		}

		if(participacao > 10){
			participacao = 10;
		}

		var indicadores_array = document.getElementsByName('indicadores[]');
		var indicadores = 0;

		for(key=0; key < indicadores_array.length; key++)  {
		    indicadores += parseInt(indicadores_array[key].value);
		}

		if(indicadores > 10){
			indicadores = 10;
		}

		var representacao_array = document.getElementsByName('representacao[]');
		var representacao = 0;

		for(key=0; key < representacao_array.length; key++)  {
		    representacao += parseInt(representacao_array[key].value);
		}

		if(representacao > 10){
			representacao = 10;
		}

		var institucional_array = document.getElementsByName('institucional[]');
		var institucional = 0;

		for(key=0; key < institucional_array.length; key++)  {
		    institucional += parseInt(institucional_array[key].value);
		}

		if(institucional > 10){
			institucional = 10;
		}

		$('#estrutura_modal').text($('#estrutura').val());
		$('#objetividade_modal').text($('#objetividade').val());
		$('#clareza_modal').text($('#clareza').val());
		$('#participacao_modal').text(participacao);
		$('#indicadores_modal').text(indicadores);
		$('#representacao_modal').text(representacao);
		$('#institucional_modal').text(institucional);
		$('#ideias_modal').text($('#ideias').val());
		$('#persistencia_modal').text($('#persistencia').val());
		$('#interesse_modal').text($('#interesse').val());
		$('#criatividade_modal').text($('#criatividade').val());
		$('#problema_modal').text($('#problema').val());
		$('#escrita_modal').text($('#escrita').val());
		$('#oral_modal').text($('#oral').val());
		$('#adicionais_modal').text($('#adicionais').val());
		$('#merito_modal').text($('#merito').val());
	});

	$('#submit').click(function(){
		alert('submitting');
		$('#formfield').submit();
	});
</script>

@endsection