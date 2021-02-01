@extends('layouts.site')

@section('content')



<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Convênios</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="row table-responsive">
		@if(session()->has('message'))
		    <div class="alert alert-success alert-dismissible fade show">
		        {{ session()->get('message') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				</button>
		    </div>
		@endif
		<div class="input-group">
                <button type="submit" data-toggle="modal" data-target="#convenioModal" class="btn btn-primary ml-auto">
                  {{ __('Adicionar') }}
                </button>
              </div>

		<table class="table table-striped">
			<thead>
				<tr>
					 <th>Universidade</th>
                      <th>País</th>
                      <th>Proeficiência</th>
                      <th>Status</th>
				</tr>
	    </thead>
	    <tbody>
	    	<div class="scrolling-pagination">
		      @foreach ($convenios as $convenio)
			      <tr>
			        <td>
			          @isset($convenio->universidade)
			            {{ $convenio->universidade }}
			          @endif
			        </td>  
			        <td> 
			          @isset($convenio->pais)
			            {{ $convenio->pais }}
			          @endif
			        </td>
			        <td>
			          @isset($convenio->proeficiencia->lingua)
			            {{ $convenio->proeficiencia->lingua.' '.$convenio->proeficiencia->nivel }}
			          @endif
			        </td>
			        @if($convenio->status == '1')
			        	<td>Ativado</td>
			        @else
			        	<td>Desativado</td>
			        	@endif
			        <td> 
			          <a href="/convenios/detalhes/{{ $convenio->id }}"  class="btn btn-primary btn-sm"> Editar</a>
			        </td>
			      </tr>
		      @endforeach
		    </div>
	    </tbody>
	  </table>
	  {{ $convenios->links("pagination::bootstrap-4") }}
	</div>

</div>

<!-- Modal-->
<div class="modal fade" id="convenioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar novo convênio</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="convenios/store" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
			          <label>Universidade</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="universidade" name="universidade" type="text" class="form-control" placeholder="Nome da Universidade" required>
			          </div>
			        </div>
					<div class="form-group">
					  	<label>País</label>
					    <div class="dropdown">
						   <select id="pais" name="pais" class="form-control custom-select">
						        @foreach($paises as $pais)
						            <option value="{{ $pais->pais_nome }}">{{ $pais->pais_nome }}</option>
						        @endforeach
						  </select>
						</div>
					</div>
					<div class="form-group">
						<label>Proeficiência</label>
						<div class="dropdown">
						   <select id="proeficiencia" name="proeficiencia" class="form-control custom-select">
						        @foreach($proeficiencias as $proeficiencia)
						            <option value="{{ $proeficiencia->id }}">{{ $proeficiencia->lingua.' '.$proeficiencia->nivel }}</option>
						        @endforeach
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
	$('#convenioModal ').modal('show');
	@endif
</script>

@endsection
