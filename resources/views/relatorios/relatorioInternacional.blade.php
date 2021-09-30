<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="card">
				<div class="card-body table-responsive">
					<h3 align="center">Estudantes Internacionais - UEFS - {{ $programa }}</h3>
		            <table  border="0.3px">
		            	<thead>
							<tr>
								<th>Nome</th>
								<th>Gênero</th>
								<th>País</th>
								<th>Programa</th>
								<th>Modalidade</th>
								<th>Vínculo</th>
								<th>Início</th>
								<th>Final</th>
								<th>Duração em meses</th>
							</tr>
				    	</thead>
				    	<tbody>
					    	@foreach ($estudantes  as $estudante)
						     	<tr>
						    		<td>
						          	@isset($estudante->nome)
						            	{{ $estudante->nome }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($estudante->sexo)
						            	{{ $estudante->sexo }}
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
						          	@isset($estudante->vinculo)
						            	{{ $estudante->vinculo }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($estudante->inicio)
						            	{{ \Carbon\Carbon::parse($estudante->inicio)->format('m/Y') }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($estudante->final)
						            	{{ \Carbon\Carbon::parse($estudante->final)->format('m/Y') }}
						          	@endif
						          	</td>

						          	@php
							          	$ts1 = strtotime($estudante->inicio);
										$ts2 = strtotime($estudante->final);

										$year1 = date('Y', $ts1);
										$year2 = date('Y', $ts2);

										$month1 = date('m', $ts1);
										$month2 = date('m', $ts2);

										$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						          	@endphp

						          	<td>
						          	@isset($diff)
						            	{{ $diff }}
						          	@endif
						          	</td>
						      	</tr>
					      	@endforeach
					      		<tr>
						      		<th>Total</th>
						      		<th>
						      			@isset($estudantes)
						            		{{ count($estudantes) }}
						          		@endif
						          	</th>
						      		<th></th>
						      		<th></th>
						      		<th></th>
						      	</tr>
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
