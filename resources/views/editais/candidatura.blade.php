@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h4 class="font-weight-bold mb-0">Detalhes do Candidato</h4>
          </div>
        </div>
      </div>
    </div>

	<div class="row">
	    <div class="col-md-12 grid-margin">
			<div class="card">
				<div class="card-body">
			          <p class="card-title">Dados candidato</p>
			    </div>
			    <div class="card-body">
			    	<div class="row">
		    			<div class="col-md-4">
		    				@if(isset($candidatura->candidato->nome))
		                	<p>
		                		<b>Nome:</b>
						        {{ $candidatura->candidato->nome }}
						    </p>
						    @endif

						    @if(isset($candidatura->candidato->curso))
						    <p>
						    	<b>Curso:</b>
						        {{ $candidatura->candidato->curso }}
						    </p>
						    @endif

						    @if(isset($candidatura->candidato->matricula))
						    <p>
					      		<b>Matrícula</b>
					      		{{ $candidatura->candidato->matricula }}
					      	</p>
					      	@endif

					      	@if(isset($candidatura->nome_professor_carta))
					      	<p>
					      		<b>Nome do Professor</b>
					      		{{ $candidatura->nome_professor_carta }}
					      	</p>
					      	@endif

					      	@if(isset($candidatura->professor_departamento_id))
					      	<p>
					      		<b>Professor Departamento</b>
					      		{{ $candidatura->departamento->nome }}
					      	</p>
					      	@endif                  
					    </div>  
		            	<div class="col-md-4">
		              		@if(isset($candidatura->primeira_opcao_universidade))
		                	<p>
					      		<b>1˚ Opção Universidade</b>
					      		{{ $candidatura->primeira_opcao_universidade }}
					      	</p>
					      	@endif

					      	@if(isset($candidatura->segunda_opcao_universidade))
					      	<p>
					      		<b>2˚ Opção Universidade</b>
					      		{{ $candidatura->segunda_opcao_universidade }}
					      	</p>
					      	@endif

					      	@if(isset($candidatura->terceira_opcao_universidade))
					      	<p>
					      		<b>3˚ Opção Universidade</b>
					      		{{ $candidatura->terceira_opcao_universidade }}
					      	</p>
					      	@endif

					      	@if(isset($candidatura->quarta_opcao_universidade))
					      	<p>
					      		<b>4˚ Opção Universidade</b>
					      		{{ $candidatura->quarta_opcao_universidade }}
					      	</p>
					      	@endif
					    </div>  
		            	<div class="col-md-4">
		            		<form class="form-prevent-multiple-submits" method="POST" action="atualizar/{{ $candidatura->id }}" enctype="multipart/form-data">
		       				{!! csrf_field() !!}
								<div class="form-group">
									<label>Status Inscrição:</label>
								    <div class="dropdown">
							    		<select id="status" name="status" class="form-control custom-select">
							                    @foreach($status as $estado)
							                    	@if( $estado->id == $candidatura->status_id )
								                     	<option selected>{{ $candidatura->status->titulo }}</option>
								                    @else
							                    		<option value="{{  $estado->titulo }}">{{ $estado->titulo }}</option>
							                    	@endif
							                    @endforeach
							            </select>
								        <div class="mt-3">
								        	<button id="btnFetch" style="float: right;" type="submit" class="btn btn-primary btn-sm button-prevent-multiple-submits">
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
			          <p class="card-title">Documentos extras do candidato</p>
			    </div>
				<div class="card-body">
					<form method="POST" class="form-prevent-multiple-submits" action="atualizar/certificado/{{ $candidatura->id }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
							      	<label>Desempenho Acadêmico</label>
							      	<div class="input-group">
							        	<input id="desempenho" value="{{$candidatura->desempenho}}" name="desempenho" type="text" class="form-control">
							      	</div>
							    </div>
							</div>
							<div class="col-md-6">
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
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('certificado') ? ' has-error' : '' }}">
									<label>Anexar Certificado de Proficiência 1</label>
									@if($candidatura->certificado_proficiencia1 != '0')
									<a  href="certificado_proficiencia1/{{ $candidatura->id }}" target="_blank">
								      Visualizar
								  	</a>
								  	@endif
									<input type="file" accept="application/pdf" id="certificado_proficiencia1" name="certificado_proficiencia1" class="form-control">
									@if ($errors->has('certificado_proficiencia1'))
									<span class="help-block">
										<strong>{{ $errors->first('certificado_proficiencia1') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Proficiência 1</label>
									<div class="dropdown">
									   	<select id="proficiencia_id1" name="proficiencia_id1" class="form-control">
									        @foreach($proeficiencias as $proeficiencia)
									        	@if($candidatura->proficiencia_id1 ==$proeficiencia->id)
									        		<option value="{{ $proeficiencia->id }}" selected="">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									        	@else	
									            	<option value="{{ $proeficiencia->id }}">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									            @endif
									        @endforeach
									  	</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('certificado_proficiencia2') ? ' has-error' : '' }}">
									<label>Anexar Certificado de Proficiência 2</label>
									@if($candidatura->certificado_proficiencia2 != '0')
									<a  href="certificado_proficiencia2/{{ $candidatura->id }}" target="_blank">
								      Visualizar
								  	</a>
								  	@endif
									<input type="file" accept="application/pdf" id="certificado_proficiencia2" name="certificado_proficiencia2" class="form-control">
									@if ($errors->has('certificado_proficiencia2'))
									<span class="help-block">
										<strong>{{ $errors->first('certificado_proficiencia2') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Proficiência 2</label>
									<div class="dropdown">
									   	<select id="proficiencia_id2" name="proficiencia_id2" class="form-control">
									        @foreach($proeficiencias as $proeficiencia)
									        	@if($candidatura->proficiencia_id2 ==$proeficiencia->id)
									        		<option value="{{ $proeficiencia->id }}" selected="">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									        	@else	
									            	<option value="{{ $proeficiencia->id }}">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									            @endif
									        @endforeach
									  	</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('certificado_proficiencia3') ? ' has-error' : '' }}">
									<label>Anexar Certificado de Proficiência 3</label>
									@if($candidatura->certificado_proficiencia3 != '0')
									<a  href="certificado_proficiencia3/{{ $candidatura->id }}" target="_blank">
								      Visualizar
								  	</a>
								  	@endif
									<input type="file" accept="application/pdf" id="certificado_proficiencia3" name="certificado_proficiencia3" class="form-control">
									@if ($errors->has('certificado_proficiencia3'))
									<span class="help-block">
										<strong>{{ $errors->first('certificado_proficiencia3') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Proficiência 3</label>
									<div class="dropdown">
									   	<select id="proficiencia_id3" name="proficiencia_id3" class="form-control">
									        @foreach($proeficiencias as $proeficiencia)
									        	@if($candidatura->proficiencia_id3 ==$proeficiencia->id)
									        		<option value="{{ $proeficiencia->id }}" selected="">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									        	@else	
									            	<option value="{{ $proeficiencia->id }}">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
									            @endif
									        @endforeach
									  	</select>
									</div>
								</div>
							</div>
						</div>

						@if($candidatura->status_id == 18)
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  <label><b>Quarta Opção Universidade</b></label>
								  <div class="input-group">
								    <select name="opcao4universidade" class="form-control">
								          @foreach($universidades as $universidade)
								          	@if($candidatura->quarta_opcao_universidade == $universidade->nome)
                            					<option value='{{ $universidade->nome }}' selected>{{ $universidade->nome." (".$universidade->vagas." vagas) (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.") "}}</option>
                          					@else
								             	<option value='{{ $universidade->nome }}'>{{ $universidade->nome." (".$universidade->vagas." vagas) "}}</option>
								            @endif
								          @endforeach
								    </select>
								  </div>
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								  <label><b>Quarta Opção Curso</b></label>
								  <div class="input-group">
								    <input id="opcao4curso" value="{{ $candidatura->quarta_opcao_curso }}"  name="opcao4curso" type="text" class="form-control">
								    @if ($errors->has('opcao1curso'))
								    <span class="help-block">
								      <strong>{{ $errors->first('opcao1curso') }}</strong>
								    </span>
								    @endif
								  </div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
							  <div class="form-group">
							    <label><b>Plano de trabalho 4</b></label>
							    @if($candidatura->plano_trabalho4 != '0')
				                	<a  href="trabalho4/{{ $candidatura->id }}" target="_blank">
			                        		Visualizar
			                        </a>
				                @endif
							    <input type="file" accept="application/pdf" id="plano_trabalho4" name="plano_trabalho4" class="form-control" >
							    @if ($errors->has('trabalho1'))
							    <span class="help-block">
							      <strong>{{ $errors->first('trabalho1') }}</strong>
							    </span>
							    @endif
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="form-group">
							    <label><b>Plano de estudos 4</b></label>
							    @if($candidatura->plano_estudo4 != '0')
				                	<a  href="estudo4/{{ $candidatura->id }}" target="_blank">
			                        		Visualizar
			                     	</a>
				                @endif
							    <input type="file" accept="application/pdf" id="plano_estudo4" name="plano_estudo4" class="form-control" >
							    @if ($errors->has('estudo1'))
							    <span class="help-block">
							      <strong>{{ $errors->first('estudo1') }}</strong>
							    </span>
							    @endif
							  </div>
							</div>
						</div>
						@endif
						{{-- @if($candidatura->status_id == 1 || $candidatura->status_id == 6 ||
																		$candidatura->status_id == 8 || $candidatura->status_id == 18) --}}
						<div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				              <button type="submit" class="btn btn-primary ml-auto utton-prevent-multiple-submits">
				                {{ __('Atualizar') }}
				              </button>
				            </div>
				          </div>
				        </div>
				        {{--@endif--}}
				    </form>
				</div>
			</div>
		</div>
	</div>

	@if(isset($avaliacao->finalizado))
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<p class="card-title mb-0">Avaliação Ccint</p>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Plano de Trabalho</th>
									<th>Curriculum</th>
									<th>Carta</th>
									<th>Desempenho</th>
									<th>Nota Final</th>
								</tr>
				    		</thead>
				    		<tbody>
				    			<tr>
				    				<th>
				    					@isset($avaliacao->plano_trabalho)
							            	{{ $avaliacao->plano_trabalho }}
							            @endif
				    				</th>
				    				<th>
				    					@isset($avaliacao->curriculum_lattes)
							            	{{ $avaliacao->curriculum_lattes }}
							            @endif
				    				</th>
				    				<th>
				    					@isset($avaliacao->carta)
							            	{{ $avaliacao->carta }}
							            @endif
				    				</th>
				    				<th>
				    					@isset($avaliacao->candidatura->desempenho)
							            	{{ $avaliacao->candidatura->desempenho }}
							            @endif
				    				</th>
				    				<th>
				    					@isset($avaliacao->nota_final)
							            	{{ $avaliacao->nota_final }}
							            @endif
				    				</th>
				    			</tr>
				    		</tbody>
				    	</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if($documentos->isNotEmpty())
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
              		<p class="card-title mb-0">Documentos Editais Genéricos</p>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
									<tr>
										 <th>Tipo de Documento</th>
									</tr>
						    </thead>
			                <tbody>
			                	@foreach($documentos as $documento)
			                	<tr>
			                    	<td>
			                    		{{ $documento->titulo }}
			                    	</td>
			                        <td> 
			                        	<a  href="documento/{{ $documento->id }}" class="btn btn-primary btn-sm" target="_blank">
					                    		Visualizar
					                    </a>
			                        </td>
			                    </tr>
			                    @endforeach
			                </tbody>
			            </table>
			        </div>
			    </div>
			</div>
		</div>
	</div>
	@endif

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
			                    @if($candidatura->plano_trabalho1 != '0')
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
			                    @endif
			                    @if($candidatura->plano_trabalho2 != '0')
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
			                    @endif
			                    @if($candidatura->plano_trabalho3 != '0')
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
			                    @endif
			                    @if(isset($candidatura->plano_trabalho4))
			                    <tr>
			                    	<td>
			                    		Plano de Trabalho 4
			                    	</td>
			                        <td> 
			                        	<a  href="trabalho4/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
			                    <tr>
			                    @if($candidatura->plano_estudo1 != '0')
			                    	<td>
			                    		Plano de Estudos 1
			                    	</td>
			                        <td> 
			                        	<a  href="estudo1/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
			                    <tr>
			                    @if($candidatura->plano_estudo2 != '0')
			                    	<td>
			                    		Plano de Estudos 2
			                    	</td>
			                        <td> 
			                        	<a  href="estudo2/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
			                    <tr>
			                    @if($candidatura->plano_estudo3 != '0')
			                    	<td>
			                    		Plano de Estudos 3
			                    	</td>
			                        <td> 
			                        	<a  href="estudo3/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
			                    @if(isset($candidatura->plano_estudo4))
			                    <tr>
			                    	<td>
			                    		Plano de Estudos 4
			                    	</td>
			                        <td> 
			                        	<a  href="estudo4/{{ $candidatura->id }}" class="btn btn-primary btn-sm" target="_blank">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
			                    @if($candidatura->carta != '0')
			                    <tr>
			                    	<td>
			                    		Carta de recomendação
			                    	</td>
			                        <td> 
			                        	<a  href="carta/{{ $candidatura->id }}" target="_blank" class="btn btn-primary btn-sm">
			                        		Visualizar
			                            </a>
			                        </td>
			                    </tr>
			                    @endif
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