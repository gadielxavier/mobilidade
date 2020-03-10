@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<form method="POST" action="/ccint/store/{{ $candidatura->id }}" enctype="multipart/form-data">
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
    			<label class="card-title">Desempenho Acadêmico (0 a 10)</label>
    		 
	          	<div class="form-group">
	            	<label>Conforme Percentil (até 10% nota 10, entre 10% e 25% nota 8, entre 25% e 50% nota 5, entre 50% e 75% nota 3, entre 75% e 100% nota 0) </label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              	<input id="desempenho" type="text" class="form-control" name="desempenho" value="{{ old('desempenho') }}" required autofocus>
	              	@if ($errors->has('desempenho'))
                    <span class="help-block">
                      <strong>{{ $errors->first('desempenho') }}</strong>
                    </span>
                    @endif
	            	</div>
	          	</div>
	    	</div>
		</div>
		<br>
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
	              	<input id="estrutura" name="estrutura" type="text" class="form-control form-control-lg border-left-0" value="{{ old('estrutura') }}" required autofocus>
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
	              		<input id="objetividade" name="objetividade" type="text" class="form-control form-control-lg border-left-0" value="{{ old('objetividade') }}" required autofocus>
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
	              	<input id="clareza" name="clareza" type="text" class="form-control form-control-lg border-left-0" value="{{ old('clareza') }}" required autofocus>
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
				<h5>Participações /Organizações em/de Reuniões/Eventos por área de formação (máx 10 pontos)</h5>
				<table class="table table-striped">
				  <thead>
				    <tr>
				       <th>Categoria</th>
				    </tr>
				  </thead>
				  <tbody>
				  	 @isset($arquivos)
					    	@foreach ($arquivos as $arquivo)
					    		@if($arquivo->comprovacao->categoria == 'Participações')
						        	<tr>
						          		<td>
						          			<div class="dropdown">
						          				<!--
								                <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								                </select>
								            -->
								            {{ $arquivo->comprovacao->titulo }}
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
						          			<input id="participacao[]" name="participacao[]" type="text" class="form-control form-control-lg border-left-0" value="{{ old('participacao[]') }}" required autofocus>
						          		</td>
						          		<td>
							            	@if ($errors->has('participacao'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('participacao') }}</strong>
						                    </span>
						                    @endif
						          		</td>
						        	</tr>
						        @endif
					    	@endforeach
					    @endif
				   </tbody>
				</table>
				<br>
				<h5>Indicadores de Produção Científica, Tecnológica e Artística</h5>
				<table class="table table-striped">
				  <thead>
				    <tr>
				       <th>Categoria</th>
				    </tr>
				  </thead>
				  <tbody>
				  	 @isset($arquivos)
					    	@foreach ($arquivos as $arquivo)
					    		@if($arquivo->comprovacao->categoria == 'Indicadores')
						        	<tr>
						          		<td>
						          			<div class="dropdown">
						          				<!--
								                <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								                </select>
								            -->
								            {{ $arquivo->comprovacao->titulo }}
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
						          			<input id="indicadores[]" name="indicadores[]" type="text" class="form-control form-control-lg border-left-0" value="{{ old('indicadores[]') }}" required autofocus>
						          		</td>
						          		<td>
							            	@if ($errors->has('indicadores'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('indicadores') }}</strong>
						                    </span>
						                    @endif
						          		</td>
						        	</tr>
						        @endif
					    	@endforeach
					    @endif
				   </tbody>
				</table>
				<br>   
				<h5>Representação/Liderança Estudantil em instâncias da Universidade (máx 10 pontos)</h5>
				<table class="table table-striped">
				  <thead>
				    <tr>
				       <th>Categoria</th>
				    </tr>
				  </thead>
				  <tbody>
				  	 @isset($arquivos)
					    	@foreach ($arquivos as $arquivo)
					    		@if($arquivo->comprovacao->categoria == 'Representação')
						        	<tr>
						          		<td>
						          			<div class="dropdown">
						          				<!--
								                <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								                </select>
								            -->
								            {{ $arquivo->comprovacao->titulo }}
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
						          			<input id="representacao[]" name="representacao[]" type="text" class="form-control form-control-lg border-left-0" value="{{ old('representacao[]') }}" required autofocus>
						          		</td>
						          		<td>
							      			@if ($errors->has('representacao'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('representacao') }}</strong>
						                    </span>
						                    @endif
						          		</td>
						        	</tr>
						        @endif
					    	@endforeach
					    @endif
				   </tbody>
				</table>
				<br>   
				<h5>Participação em Programa Acadêmico Institucional ou Estágios (máx 10 pontos)</h5>
				<table class="table table-striped">
				  <thead>
				    <tr>
				       <th>Categoria</th>
				    </tr>
				  </thead>
				  <tbody>
				  	 @isset($arquivos)
					    	@foreach ($arquivos as $arquivo)
					    		@if($arquivo->comprovacao->categoria == 'Institucional')
						        	<tr>
						          		<td>
						          			<div class="dropdown">
						          				<!--
								                <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								                </select>
								            -->
								            {{ $arquivo->comprovacao->titulo }}
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
						          			<input id="institucional[]" name="institucional[]" type="text" class="form-control form-control-lg border-left-0" value="{{ old('institucional[]') }}" required autofocus>
						          		</td>
						          		<td>
							            	@if ($errors->has('institucional'))
						                    <span class="help-block">
						                      <strong>{{ $errors->first('institucional') }}</strong>
						                    </span>
						                    @endif
						          		</td>
						        	</tr>
						        @endif
					    	@endforeach
					    @endif
				   </tbody>
				</table>
				<br> 
	      	</div>
	  	</div>
	  	<br>
	    <div class="card">
	    	<div class="card-body">
	    		<label class="card-title">Carta de Recomendação</label>
	          	<a  href="{{ route('ccint.trabalho1', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
                <div class="form-group">
		        	<label>
		        		Capacidade de aprender novas idéias, Capacidade de trabalhar e persistência, Motivação, entusiasmo e interesse, Capacidade de resolver problema, Imaginação e criatividade, Expressão escrita, Expressão oral (até 5,0)
		        	</label>
		        	<div class="input-group">
		        		<div class="input-group-prepend bg-transparent">
		              	</div>
		              	<input id="ideias" name="ideias" type="text" class="form-control form-control-lg border-left-0" value="{{ old('ideias') }}" required autofocus>
		            	@if ($errors->has('ideias'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('ideias') }}</strong>
	                    </span>
	                    @endif
		            </div>
		        </div>
	          	<div class="form-group">
	            	<label>Informações adicionais fornecidas (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="adicionais" name="adicionais" type="text" class="form-control form-control-lg border-left-0" value="{{ old('adicionais') }}" required autofocus>
	              		@if ($errors->has('adicionais'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('adicionais') }}</strong>
	                    </span>
	                    @endif
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Mérito do candidato (até 3,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="merito" name="merito" type="text" class="form-control form-control-lg border-left-0" value="{{ old('merito') }}" required autofocus>
	              		@if ($errors->has('merito'))
	                    <span class="help-block">
	                      <strong>{{ $errors->first('merito') }}</strong>
	                    </span>
	                    @endif
	            	</div>
	          	</div>
	          	<div class="mt-3">
	            	<div class="form-group">
	              		<div class="input-group">
	                		<button type="submit" class="btn btn-primary ml-auto">
	                  			{{ __('Enviar') }}
	                		</button>
	              		</div>
	            	</div>
	          	</div>
      		</div>
     	</div>
	</form>
</div>

@endsection