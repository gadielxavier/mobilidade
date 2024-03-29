@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Equipe</h4>
	        </div>
	        <div>
        		<button type="submit" data-toggle="modal" data-target="#funcionarioModal" class="btn btn-primary btn-icon-text btn-rounded">
        			<i class="ti-user btn-icon-prepend"></i>
                 	Adicionar Equipe
                </button>
      		</div>
	      </div>
	    </div>
	</div>

	<div class="row">
	    <div class="col-md-12 grid-margin">
	    	<div class="card">
            	<div class="card-body">
					<div class="table-responsive">
						{{ $equipe->links("pagination::bootstrap-4") }}
						<table class="table table-striped">
							<thead>
								<tr>
									 <th>Nome</th>
									 <th>Email</th>
									 <th>Tipo</th>
								</tr>
					    	</thead>
							<tbody>
							@foreach ($equipe as $funcionario)
								<tr>
									<td>
									@isset($funcionario->name)
										{{ $funcionario->name }}
									@endif
									</td>
									<td>
									@isset($funcionario->email)
										{{ $funcionario->email }}
									@endif
									</td>
									<td>
									@isset($funcionario->privilegio)
										@if($funcionario->privilegio == 2)
											Servidor Aeri
										@elseif($funcionario->privilegio == 3)
											Participante CCint
										@endif
									@endif
									</td>
									<td>
										<a href="#editarModal_{{ $funcionario->id }}" data-toggle="modal" class="btn btn-primary btn-sm"> Editar</a>
										<a href="#deleteModal_{{ $funcionario->id }}" data-toggle="modal" class="btn btn-danger btn-sm"> Excluir</a>

										<div id="editarModal_{{ $funcionario->id }}" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
														<button class="close" type="button" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">×</span>
														</button>
													</div>
													<div class="modal-body">
														<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="equipe/editar/{{ $funcionario->id }}">
															{{ csrf_field() }}
															<h6>Você tem certeza que deseja editar esta funcionário?</h6>

															<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
																<label for="name">Login</label>

																<div class="input-group">
																	<input id="name" type="text" class="form-control" name="name" value="{{ $funcionario->name }}" required autofocus>

																	@if ($errors->has('name'))
																		<span class="help-block">
																			<strong>{{ $errors->first('name') }}</strong>
																		</span>
																	@endif
																</div>
															</div>

															<div class="form-group">
																<label>Tipo Usuuário</label>
																<div class="dropdown">
																<select id="tipo_usuario" name="tipo_usuario" class="form-control custom-select">
																	<option @if($funcionario->privilegio == 2) selected @endif value="2">Servidor Aeri</option>
																	<option @if($funcionario->privilegio == 3) selected @endif value="3">Participante CCint</option>
																</select>
																</div>
															</div>

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

										<div id="deleteModal_{{ $funcionario->id }}" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
														<button class="close" type="button" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">×</span>
														</button>
													</div>
													<div class="modal-body">
														<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="equipe/delete/{{ $funcionario->id }}">
														{{ csrf_field() }}
														<input type="hidden" name="_method" value="DELETE">
														<h6>Você tem certeza que deseja excluir esta funcionário?</h6>

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
								</tr>
							@endforeach
							</tbody>
					  	</table>
					  {{ $equipe->links("pagination::bootstrap-4") }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal-->
<div class="modal fade" id="funcionarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar novo funcionário</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-prevent-multiple-submits" method="POST" action="equipe/store" enctype="multipart/form-data">
					{{ csrf_field() }}
					 	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Login</label>

                            <div class="input-group">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email</label>

                            <div class="input-group">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
				            <label>Tipo Usuuário</label>
				            <div class="dropdown">
				               <select id="tipo_usuario" name="tipo_usuario" class="form-control custom-select">
				                  <option selected value="2">Servidor Aeri</option>
				                  <option value="3">Participante CCint</option>
				              </select>
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
	$('#funcionarioModal ').modal('show');
	@endif
</script>

@endsection

