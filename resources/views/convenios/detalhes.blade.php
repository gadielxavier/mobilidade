@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      		<h4 class="card-title">Atualizar convênio</h4>
      		<p class="card-description">
        		Atualizar os  dados do convênio
      		</p>

			<form class="form-prevent-multiple-submits" method="POST" action="{{ route('convenios.update', $convenio->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
           		<div class="form-group">
			      	<label>Universidade</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend bg-transparent">
			        	</div>
			        	<input id="universidade" name="universidade" value="{{ $convenio->universidade }}" type="text" class="form-control form-control-lg border-left-0" placeholder="Nome da universidade" required>
			      	</div>
			    </div>
			    <div class="form-group">
			      	<label>País</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend bg-transparent">
			        	</div>
			        	<input id="pais" name="pais" value="{{ $convenio->pais }}" type="text" class="form-control form-control-lg border-left-0" placeholder="País da universidade" required>
			      	</div>
			    </div>
			    <div class="form-group">
					<label>Proeficiência</label>
					<div class="dropdown">
					   <select id="proeficiencia" name="proeficiencia" class="form-control custom-select">
					        @foreach($proeficiencias as $proeficiencia)
					            <option value="{{ $proeficiencia->id }}">{{ $proeficiencia->nome }}</option>
					        @endforeach
					  </select>
					</div>
				</div>
				<div class="mt-3">
					<div class="form-group">
				  		<div class="input-group">
				    		<button id="btnFetch" type="submit" class="btn btn-primary ml-auto button-prevent-multiple-submits">
				      			{{ __('Atuaizar') }}
				    		</button>
				  		</div>
					</div>
				</div>
        </form>
		</div>
	</div>
</div>

@endsection

@section('scripts')

	<script src="js/submit.js"></script>

@endsection

