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
					<h3 align="center">Estatística da Mobilidade Estudantil - UEFS - {{ $tipo }}</h3>
		            <table  border="0.3px">
		            	<thead>
							<tr>
								<th>Candidato</th>
								<th>Curso</th>
								<th>Matrícula</th>
								<th>Edital</th>
								<th>Ies Anfitriã</th>
							</tr>
				    	</thead>
				    	<tbody>
					    	@foreach ($candidaturas  as $candidatura)
						     	<tr>
						    		<td>
						          	@isset($candidatura->candidato->nome)
						            	{{ $candidatura->candidato->nome }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($candidatura->candidato->curso)
						            	{{ $candidatura->candidato->curso }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($candidatura->candidato->matricula)
						            	{{ $candidatura->candidato->matricula }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($candidatura->edital->nome)
						            	{{ $candidatura->edital->nome.' '.$candidatura->edital->numero }}
						          	@endif
						          	</td>
						          	<td>
						          	@isset($candidatura->ies_anfitria)
						            	{{ $candidatura->ies_anfitria }}
						          	@endif
						          	</td>
						      	</tr>
					      	@endforeach
					      		<tr>
						      		<th>Total</th>
						      		<th>
						      			@isset($candidaturas)
						            		{{ count($candidaturas) }}
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
