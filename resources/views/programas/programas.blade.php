@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      	<div class="d-flex justify-content-between align-items-center">
	        	<div>
	          		<h4 class="font-weight-bold mb-0">Programas</h4>
	        	</div>
	      		<div>
	      			<button type="submit" data-toggle="modal" data-target="#programaModal" class="btn btn-primary btn-icon-text btn-rounded">
                		<i class="ti-clipboard btn-icon-prepend"></i>Adicionar Programa
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
              	<h4 class="card-title">Programas In</h4>
              	<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								 <th>Nome</th>
							</tr>
				    	</thead>
					    <tbody>
					    	<div class="scrolling-pagination">
						      	@foreach ($programasIn as $programa)
							      	<tr>
							        	<td>
							        	@isset($programa->nome)
				                        	{{ $programa->nome }}
				                    	@endif
							        	</td>  
							        	<td> 
							          		<button type="submit" data-toggle="modal" data-target="#editarModal_{{ $programa->id }}"  class="btn btn-primary btn-sm"> Editar</button>
							        	</td>
							      	</tr>
							      	<!-- Editar Modal-->
									<div class="modal fade" id="editarModal_{{ $programa->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Editar programa</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
												<div class="modal-body">
													<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="programas/update/{{ $programa->id }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
												          <label>Nome</label>
												          <div class="input-group">
												            <div class="input-group-prepend bg-transparent">
												            </div>
												            <input value="{{$programa->nome}}" id="nome" name="nome" type="text" class="form-control" placeholder="Nome do Programa" required>
												          </div>
												        </div>
												        <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
												          	<label>Tipo</label>
												          	<select name="tipo" class="form-control">
												          		@if($programa->tipo == 1)
											                		<option selected value='1'>In</option>
											                		<option value='2'>Out</option>
											                	@else
											                		<option value='1'>In</option>
											                		<option selected="" value='2'>Out</option>
											                	@endif
								               			 	</select>
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
				  {{ $programasIn->links("pagination::bootstrap-4") }}
				</div>
            </div>
          </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Programas Out</h4>
              	<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								 <th>Nome</th>
							</tr>
				    	</thead>
					    <tbody>
					    	<div class="scrolling-pagination">
						      	@foreach ($programasOut as $programa)
							      	<tr>
							        	<td>
							        	@isset($programa->nome)
				                        	{{ $programa->nome }}
				                    	@endif
							        	</td>  
							        	<td> 
							          		<button type="submit" data-toggle="modal" data-target="#editarModal_{{ $programa->id }}"  class="btn btn-primary btn-sm"> Editar</button>
							        	</td>
							      	</tr>
							      	<!-- Editar Modal-->
									<div class="modal fade" id="editarModal_{{ $programa->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Editar programa</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
												<div class="modal-body">
													<form class="form-horizontal form-prevent-multiple-submits"method="POST" action="programas/update/{{ $programa->id }}" enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
												          <label>Nome</label>
												          <div class="input-group">
												            <div class="input-group-prepend bg-transparent">
												            </div>
												            <input value="{{$programa->nome}}" id="nome" name="nome" type="text" class="form-control" placeholder="Nome do Programa" required>
												          </div>
												        </div>
												        <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
												          	<label>Tipo</label>
												          	<select name="tipo" class="form-control">
												          		@if($programa->tipo == 1)
											                		<option selected value='1'>In</option>
											                		<option value='2'>Out</option>
											                	@else
											                		<option value='1'>In</option>
											                		<option selected="" value='2'>Out</option>
											                	@endif
								               			 	</select>
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
				  {{ $programasOut->links("pagination::bootstrap-4") }}
				</div>
            </div>
          </div>
        </div>
	</div>
</div>

<!-- Cadastrar Modal-->
<div class="modal fade" id="programaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar novo programa</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="programas/store" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
			          <label>Nome</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome do Programa" required>
			          </div>
			        </div>
			        <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
			          	<label>Tipo</label>
			          	<select name="tipo" class="form-control">
		                      <option value='1'>In</option>
		                      <option value='2'>Out</option>
           			 	</select>
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
	$('#programaModal ').modal('show');
	@endif
</script>

@endsection
