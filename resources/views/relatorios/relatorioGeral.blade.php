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
					<h3 align="center">Estatística da Mobilidade Estudantil - UEFS - Por {{ $tipo }}</h3>
		            <table  border="0.3px">
		            	<thead>
							<tr>
								@isset($tipo)
									<th>{{ $tipo }}</th>
								@endif
								@foreach ($candidaturasAno  as $key => $ano)
									@isset($key)
						            	<th>{{ $key }}</th>
						         	@endif
								@endforeach
								<th>Total</th>
							</tr>
				    	</thead>
				    	<tbody>
					    	@foreach ($candidaturas  as $key => $valor)
						     	<tr>
						    		<td>
						          	@isset($key)
						            	{{ $key }}
						          	@endif
						          	</td>
						          	@foreach ($candidaturasAno  as $chave => $ano)
						          		@isset($tabela[$key][$chave])
						          			<td>{{ $tabela[$key][$chave] }}</td>
						          		@else
						          			<td>0</td>
						          		@endif
						          	@endforeach
						          	<td>
						          	@isset($valor)
						            	{{ count($valor) }}
						          	@endif
						          	</td>
						      	</tr>
					      	@endforeach
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
