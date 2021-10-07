@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      	<div class="d-flex justify-content-between align-items-center">
	        	<div>
	          		<h4 class="font-weight-bold mb-0">Documentos</h4>
	        	</div>
	      		<div>
	      			<button type="submit" data-toggle="modal" data-target="#documentoModal" class="btn btn-primary btn-icon-text btn-rounded">
                		<i class="ti-file btn-icon-prepend"></i>Adicionar Documento
            		</button>
	      		</div>
	      	</div>
	    </div>
	</div>

	@if(session()->has('message'))
	    <div class="alert alert-success alert-dismissible fade show">
	        {{ session()->get('message') }}
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			</button>
	    </div>
	@endif

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              	<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								 <th>Nome</th>
							</tr>
				    	</thead>
					    <tbody>
					    	<div class="scrolling-pagination">
						      	@foreach ($documentos as $documento)
							      	<tr>
							        	<td>
							        	@isset($documento->titulo)
				                        	{{ $documento->titulo }}
				                    	@endif
							        	</td>  
							        	<td> 
							          		<button type="submit" data-toggle="modal" data-target="#editarModal_{{ $documento->id }}"  class="btn btn-primary btn-sm"> Editar</button>
							        	</td>
							      	</tr>
							      	<!-- Editar Modal-->
									<div class="modal fade" id="editarModal_{{ $documento->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Editar documento</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
												<div class="modal-body">
													<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="documentos/update/{{ $documento->id }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
												          <label>Nome</label>
												          <div class="input-group">
												            <div class="input-group-prepend bg-transparent">
												            </div>
												            <input value="{{$documento->titulo}}" id="nome" name="nome" type="text" class="form-control" placeholder="Nome do documento" required>
												          </div>
												        </div>
												        <div class="modal-footer">
													        <div class="mt-3">
													        	<div class="form-group">
													            	<div class="input-group">
													              		<button type="submit" class="btn btn-primary ml-auto">
													                		{{ __('Atualizar') }}
													              		</button>
													            	</div>
													          	</div>
													        </div>
													    </div>
													</form>
												</div>
											</div>
										</div>
									</div>
						      	@endforeach
						    </div>
					    </tbody>
				  	</table>
				  {{ $documentos->links("pagination::bootstrap-4") }}
				</div>
            </div>
          </div>
        </div>
	</div>
</div>

<!-- Cadastrar Modal-->
<div class="modal fade" id="documentoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar novo documento</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="documentos/store" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
			          <label>Nome</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome do documento" required>
			          </div>
			        </div>
			        <div class="modal-footer">
				        <div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				              <button type="submit" class="btn btn-primary ml-auto">
				                {{ __('Cadastrar') }}
				              </button>
				            </div>
				          </div>
				        </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">
	@if (count($errors) > 0)
	$('#documentoModal ').modal('show');
	@endif
</script>

@endsection
