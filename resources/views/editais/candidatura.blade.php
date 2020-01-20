@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">

	<div class="row">
	    <div class="col-md-12 grid-margin stretch-card">
	      <div class="card">
	        <div class="card-body">
	          <p class="card-title">Dados candidato</p>
	          <div class="row">
	            <div class="col-md-3">
	              <div>
	              	<img src="../../../{{ $candidatura->candidato->foto_perfil }}" width="150" height="200" alt="profile"/>
	              </div>  
	            </div>
	            <div class="col-md-4">
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
	            <div class=" col-md-5">
	            	<form method="POST" action="atualizar/{{ $candidatura->id }}" enctype="multipart/form-data">
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
						        	<button type="submit" class="btn btn-primary btn-sm">
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
			                    		Percentual de carga horária concluída
			                    	</td>
			                        <td> 
			                        	<a  href="percentual/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Guia de matrícula
			                    	</td>
			                        <td> 
			                        	<a  href="matricula/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Histórico escolar
			                    	</td>
			                        <td> 
			                        	<a  href="historico/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Curriculum no formato completo da Plataforma Lattes/CNPQ
			                    	</td>
			                        <td> 
			                        	<a  href="curriculum/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 1
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho1/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 2
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho2/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 3
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho3/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 1
			                    	</td>
			                        <td> 
			                        	<a  href="estudo1/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 2
			                    	</td>
			                        <td> 
			                        	<a  href="estudo2/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 3
			                    	</td>
			                        <td> 
			                        	<a  href="estudo3/{{ $candidatura->id }}" class="btn btn-primary btn-sm">
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