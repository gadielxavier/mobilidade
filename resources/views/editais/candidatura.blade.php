@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">

	<div class="row">
	    <div class="col-md-12 grid-margin stretch-card">
	      <div class="card">
	      	@if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif
	        <div class="card-body">
	          <p class="card-title">Dados candidato</p>
	          <div class="row">
	            <div class="col-md-1">
	            </div>
	            <div class="col-md-5">
	              <div class="row">
	                <div>
	                	<p>
	                		<b>Nome:</b>
					        {{ $candidatura->candidato->nome }}
					    </p>
					    <p>
					    	<b>Curso:</b>
					        {{ $candidatura->candidato->curso }}
					    </p>
					    <p>
				      		<b>Matricula</b>
				      		{{ $candidatura->candidato->matricula }}
				      	</p>
	                </div>
	              </div>
	            </div>
	            <div class=" col-md-6">
	            	<form class="form-prevent-multiple-submits" method="POST" action="atualizar/{{ $candidatura->id }}" enctype="multipart/form-data">
           			{!! csrf_field() !!}
						<div class="form-group">
							<label>Status Inscrição:</label>
						    <div class="dropdown">
					    		<select id="status" name="status" class="form-control custom-select">
					                <option selected>{{ $candidatura->status->titulo }}</option>
					                    @foreach($status as $estado)
					                    	<option value="{{  $estado->titulo }}">{{ $estado->titulo }}</option>
					                    @endforeach
					            </select>
						        <div class="mt-3">
						        	<button id="btnFetch" type="submit" class="btn btn-primary btn-sm button-prevent-multiple-submits">
					                  {{ __('Atuaizar') }}
					                </button>
						        </div>
						    </div>
					    </div>
					</form>
				</div>
	          </div>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="row">
	 	<div class="col-md-12 grid-margin stretch-card">
	 		<div class="card">
				<div class="card-body">
					<form method="POST" action="atualizar/certificado/{{ $candidatura->id }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="form-group{{ $errors->has('certificado') ? ' has-error' : '' }}">
							<label>Anexar Certificado de Proficiência</label>
							@if($candidatura->certificado != '0')
							<a  href="certificado/{{ $candidatura->id }}" target="_blank">
			                  Visualizar
			              	</a>
			              	@endif
							<input type="file" accept="application/pdf" id="certificado" name="certificado" class="form-control">
							@if ($errors->has('certificado'))
							<span class="help-block">
								<strong>{{ $errors->first('certificado') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group{{ $errors->has('carta') ? ' has-error' : '' }}">
							<label>Anexar Carta de Recomendação</label>
							@if($candidatura->carta != '0')
							<a  href="carta/{{ $candidatura->id }}" target="_blank">
			                  Visualizar
			              	</a>
			              	@endif
							<input type="file" accept="application/pdf" id="carta" name="carta" class="form-control">
							@if ($errors->has('carta'))
							<span class="help-block">
								<strong>{{ $errors->first('carta') }}</strong>
							</span>
							@endif
						</div>
						<div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				              <button type="submit" class="btn btn-primary ml-auto">
				                {{ __('Enviar') }}
				              </button>
				            </div>
				          </div>
				        </div>
				    </form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
              		<p class="card-title mb-0">Documentos do candidato</p>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
									<tr>
										 <th>Tipo de Documento</th>
									</tr>
						    </thead>
			                <tbody>
			                	<tr>
			                    	<td>
			                    		Foto 3/4
			                    	</td>
			                        <td> 
			                        	<a  href="foto/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
					                    		Visualizar
					                    </a>
			                        </td>
			                    </tr>
			                	<tr>
			                    	<td>
			                    		Percentual de carga horária concluída
			                    	</td>
			                        <td> 
			                        	<a  href="percentual/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Guia de matrícula
			                    	</td>
			                        <td> 
			                        	<a  href="matricula/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Histórico escolar
			                    	</td>
			                        <td> 
			                        	<a  href="historico/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Curriculum no formato completo da Plataforma Lattes/CNPQ
			                    	</td>
			                        <td> 
			                        	<a  href="curriculum/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 1
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho1/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 2
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho2/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 3
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho3/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 1
			                    	</td>
			                        <td> 
			                        	<a  href="estudo1/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 2
			                    	</td>
			                        <td> 
			                        	<a  href="estudo2/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 3
			                    	</td>
			                        <td> 
			                        	<a  href="estudo3/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>
			        </div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

	<script src="js/submit.js"></script>

@endsection