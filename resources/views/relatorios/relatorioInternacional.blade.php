<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
		</style>
	</head>
	<body>
		<div class="ccontainer-fluid">
			<div class="card">
				<div class="card-body table-responsive">
					<h3 align="center">Estudantes Internacionais - UEFS - {{ $programa }}</h3>
		            <table  border="0.3px">
		            	<thead>
							<tr>
								<th>Nome</th>
								<th>País</th>
								<th>Programa</th>
								<th>Modalidade</th>
								<th>Previsão de Conclusão</th>
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
						          	@isset($estudante->final)
						            	{{ \Carbon\Carbon::parse($estudante->final)->format('m/Y') }}
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
