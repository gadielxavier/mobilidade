<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body table-responsive">
			<img src="theme/images/cabecalho.png" alt="cabecalho" width="100%" height="100%">

			<h3 align="center">EDITAL {{$edital->nome.' '.$edital->numero}}</h3> 
			<h3 align="center">RESULTADO DA 2ª FASE</h3> 
      		<h4 class="card-title">A AERI INFORMA O RESULTADO POR ORDEM DE CLASSIFICAÇÃO:</h4>
      		@if(session()->has('message'))
			    <div class="alert alert-success alert-dismissible fade show">
			        {{ session()->get('message') }}
			        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
			    </div>
			@endif
			@if($edital->status->id >= 9)
		        {{ csrf_field() }}
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
					    	@foreach ($avaliacoes as $avaliacao)
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
		        </form>
	        @endif
		</div>
	</div>
	<h4 align="right" >Feira de Santana, {{ \Carbon\Carbon::now()->format('d/m/Y')  }}</h4>
	<h4 align="center">Eneida Soanne Matos Campos de Oliveira</h4>
	<h4 align="center">Assessora Especial de Relações Institucionais</h4>
</div>
