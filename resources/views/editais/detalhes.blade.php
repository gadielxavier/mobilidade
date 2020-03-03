@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Edital {{$edital->nome.' '.$edital->numero}}</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="card">
    	<div class="card-body">
    		<h4 class="card-title">Informações do Edital</h4>
      			<div class="row table-responsive">
      				<table class="table table-striped">
      					<thead>
      						<tr>
      							<th>Nome</th>
			                     <th>Número</th>
			                     <th>Bolsas</th>
			                     <th>Encerramento Inscrição</th>
			                 </tr>
			             </thead>
			             <tbody>
		             		<tr>
					        	<td>
					            	{{ $edital->nome }}
					            </td>
						        <td> 
						            {{ $edital->numero }}
						        </td>
						        <td>
						        	{{ $edital->qtd_bolsas }}
						        </td>
						        <td>
						        	{{ $edital->fim_inscricao->format('d/m/Y') }}
						        </td>
						        <td>
						          	<a href="/editais/atualizar/{{ $edital->id }}"  class="btn btn-primary btn-sm"> Editar</a>
						        </td>
						        <!--
						        <td>
						          	<a href="#deleteModal_{{ $edital->id }}" data-toggle="modal" class="btn btn-danger btn-sm"> Excluir</a>

						          	<div id="deleteModal_{{ $edital->id }}" class="modal fade">
						          		<div class="modal-dialog">
						          			<div class="modal-content">
						          				<div class="modal-header">
						          					<h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
						          					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						          						<span aria-hidden="true">×</span>
						          					</button>
						          				</div>
						          				<div class="modal-body">
						          					<form class="form-horizontal" method="POST" action="delete/{{ $edital->id }}">
								                      {{ csrf_field() }}
								                      <input type="hidden" name="_method" value="DELETE">
								                      <h6>Você tem certeza que deseja excluir esta edital?</h6>

								                    	<div class="modal-footer">
								                      		<div class="form-group">
								                        		<button type="submit" class="btn btn-primary">
								                          			Sim
								                        		</button>
								                        		<button type="button" data-dismiss="modal" class="btn btn-outline-primary">
								                          			Não
								                        		</button>
								                      		</div>
								                    	</div>
								      				</form>
								      			</div>
								      		</div>
								      	</div>
								    </div>
								</td>
							-->
					      	</tr>
			             </tbody>
			         </table>
      			</div>
      	</div>
     </div>

	<div class="card">
    	<div class="card-body">
      		<h4 class="card-title">Candidatos Inscritos</h4>
      			<div class="row table-responsive">
      				<table class="table table-striped">
      					<thead>
      						<tr>
      							<th>Nome</th>
			                     <th>Curso</th>
			                     <th>Situaçâo</th>
			                 </tr>
			             </thead>
			             <tbody>
			             	@foreach ($candidaturas as $candidatura)

			             		<tr>
						        	<td>
						          		@isset($candidatura->candidato->nome)
						            		{{ $candidatura->candidato->nome }}</td>
						          		@endif
							        <td> 
							          	@isset($candidatura->candidato->curso)
							            	{{ $candidatura->candidato->curso }}
							          	@endif
							        </td>
							        <td>
							          	@isset($candidatura->status->titulo)
							            	{{ $candidatura->status->titulo }}</td>
							          	@endif
							        <td>
							          	<a href="candidatura/{{ $candidatura->id }}"  class="btn btn-primary btn-sm"> Visualizar</a>
							        </td>
						      	</tr>
					      @endforeach
			             </tbody>
			         </table>
			         {{ $candidaturas->links("pagination::bootstrap-4") }}
      			</div>
      	</div>
     </div>
</div>

@endsection