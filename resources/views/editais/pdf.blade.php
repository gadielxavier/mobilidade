<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
		  body { font-family: DejaVu Sans, sans-serif; }
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="card">
				<div class="card-body table-responsive">
					<!-- <img src="theme/images/cabecalho.png" alt="cabecalho" width="100%" height="100%"> -->

					<h3 align="center">EDITAL {{$edital->nome.' '.$edital->numero}}</h3> 
					<h3 align="center">{{ $edital->status->titulo }}</h3> 
		      		

					@if($edital->status->id >= 9)
				        {{ csrf_field() }}
				        <h4 class="card-title">A AERI INFORMA O RESULTADO POR ORDEM DE CLASSIFICAÇÃO:</h4>
				            <table  border="0.3px">
				            	<thead>
									<tr>
										<th>#</th>
										<th>Estudante</th>
										<th>Matrícula</th>
										<th>Curso</th>
										<th>Ies Anfitriã</th>
									</tr>
						    	</thead>
						    	<tbody>
							    	@foreach ($lista_principal as $avaliacao)
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
								            	{{ $avaliacao->candidatura->candidato->matricula }}
								            @endif
								        	</td>
								        	<td>
								          	@isset($avaliacao->id)
								            	{{ $avaliacao->candidatura->candidato->curso }}
								            @endif
								        	</td>
								        	<td>
								          	@isset($avaliacao->id)
								            	{{ $avaliacao->candidatura->ies_anfitria }}
								            @endif
								        	</td>
								      	</tr>
							      	@endforeach
							    </tbody>
							</table>
							@if(!empty($lista_reserva))
							<h4 class="card-title">Lista Reserva:</h4>
				            <table  border="0.3px">
				            	<thead>
									<tr>
										<th>#</th>
										<th>Estudante</th>
										<th>Matrícula</th>
										<th>Curso</th>
										<th>Ies Anfitriã</th>
									</tr>
						    	</thead>
						    	<tbody>
							    	@foreach ($lista_reserva as $avaliacao)
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
								            	{{ $avaliacao->candidatura->candidato->matricula }}
								            @endif
								        	</td>
								        	<td>
								          	@isset($avaliacao->id)
								            	{{ $avaliacao->candidatura->candidato->curso }}
								            @endif
								        	</td>
								        	<td>
								          	@isset($avaliacao->id)
								            	{{ $avaliacao->candidatura->ies_anfitria }}
								            @endif
								        	</td>
								      	</tr>
							      	@endforeach
							    </tbody>
							</table>
							@endif
				        </form>
				    @else
						<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('resultado.update', $edital->id) }}" enctype="multipart/form-data">
				            {{ csrf_field() }}
				            <table border="0.3px">
				            	<thead>
									<tr>
										<th>Nome</th>
										<th>Matrícula</th>
										<th>Curso</th>
										<th>Status</th>
										<th>Primeira Opção</th>
										<th>Segunda Opção</th>
										<th>Terceira Opção</th>
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
											@if(isset($candidatura->primeira_opcao_universidade) && $candidatura->primeira_opcao_universidade != '0')
								            	{{ $candidatura->primeira_opcao_universidade }}
								            @endif
								        	</td>
								          	<td>
											@if(isset($candidatura->segunda_opcao_universidade) && $candidatura->segunda_opcao_universidade != '0')
								            	{{ $candidatura->segunda_opcao_universidade }}
								            @endif
								        	</td>
								          	<td>
											@if(isset($candidatura->terceira_opcao_universidade) && $candidatura->terceira_opcao_universidade != '0' )
								            	{{ $candidatura->terceira_opcao_universidade }}
								            @endif
								        	</td>
								      	</tr>
							      	@endforeach
							    </tbody>
							</table>
				        </form>
			        @endif
				</div>
			</div>
			<h4 align="center">{{ $instrucoes }}</h4>
			<h4 align="right" >Feira de Santana, {{ \Carbon\Carbon::now()->format('d/m/Y')  }}</h4>
			<h4 align="center">{{ $assinatura }}</h4>
			<h4 align="center">{{ $cargo }}</h4>
		</div>
	</body>
</html>
