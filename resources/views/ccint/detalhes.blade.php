@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<form method="POST" action="/editais/ccint/cadastrar/" enctype="multipart/form-data">
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

		<div class="card">
    	<div class="card-body">
    		<label class="card-title">Desempenho Acadêmico (0 a 10)</label>
    		 
	          	<div class="form-group">
	            	<label>Conforme Percentil (até 10% nota 10, entre 10% e 25% nota 8, entre 25% e 50% nota 5, entre 50% e 75% nota 3, entre 75% e 100% nota 0) </label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              	<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
	            	</div>
	          	</div>
	    	</div>
		</div>
		<br>
		<div class="card">
	    	<div class="card-body">
	    		<label class="card-title">Plano de trabalho</label>
	          	<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
	          	<div class="form-group">
	            	<label>Estrutura do texto, contemplando os itens propostos (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              	</div>
	              	<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Objetividade (até 6,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Clareza na escolha da IES e das disciplinas (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              	<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	      	</div>
	  	</div>
	  	<br>
	  	<div class="card">
	    	<div class="card-body">
				<label class="card-title">Currículo Lattes</label>
				<a  href="{{ route('editais.curriculum', $candidatura->id) }}" target="_blank">
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
								               <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								              </select>
								            </div>
						          		</td>
						          		<td>
						          			<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
						                		Visualizar
						                	</a>
						          		</td>
						          	</tr>
						          	<tr>
						          		<td>
						          			<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
								               <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								              </select>
								            </div>
						          		</td>
						          		<td>
						          			<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
						                		Visualizar
						                	</a>
						          		</td>
						          	</tr>
						          	<tr>
						          		<td>
						          			<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
								               <select id="curso" name="curso" class="form-control custom-select">
								                  <option selected>{{ $arquivo->comprovacao->titulo }}</option>
								                    @foreach($comprovacoes as $comprovacao)
								                        <option value="{{ $comprovacao->id }}">{{ $comprovacao->titulo }}</option>
								                    @endforeach
								              </select>
								            </div>
						          		</td>
						          		<td>
						          			<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
						                		Visualizar
						                	</a>
						          		</td>
						          	</tr>
						          	<tr>
						          		<td>
						          			<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
					    		@if($arquivo->comprovacao->categoria == 'Representação')
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
						          			<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
						                		Visualizar
						                	</a>
						          		</td>
						          	</tr>
						          	<tr>
						          		<td>
						          			<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
	          	<a  href="{{ route('editais.trabalho1', $candidatura->id) }}" target="_blank">
                	Visualizar
                </a>
                <div class="form-group">
		        	<label>Capacidade de aprender novas idéias</label>
		        	<div class="input-group">
		        		<div class="input-group-prepend bg-transparent">
		              	</div>
		              	<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
		            </div>
		        </div>
		        <div class="form-group">
		        	<label>Capacidade de trabalhar e persistência</label>
		        	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Motivação, entusiasmo e interesse</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              	<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            </div>
	          	</div>
	          	<div class="form-group">
	            	<label>Capacidade de resolver problemas</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Imaginação e criatividade</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Expressão escrita</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Expressão oral</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Informações adicionais fornecidas (até 2,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
	            	</div>
	          	</div>
	          	<div class="form-group">
	            	<label>Mérito do candidato (até 3,0)</label>
	            	<div class="input-group">
	              		<div class="input-group-prepend bg-transparent">
	              		</div>
	              		<input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" required>
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