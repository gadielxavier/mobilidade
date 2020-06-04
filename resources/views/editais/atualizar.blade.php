@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      		<h4 class="card-title">Atualizar Edital</h4>
      		<p class="card-description">
        		Atualizar os  dados do edital
      		</p>

			<form method="POST" action="{{ route('editais.update', $edital->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
           		<div class="form-group">
					<label>Status:</label>
				    <div class="dropdown">
			    		<select id="status" name="status" class="form-control custom-select">
			                <option value="{{ $edital->status->id }}" selected>{{ $edital->status->titulo }}</option>
			                    @foreach($status as $estado)
			                    	<option value="{{  $estado->id }}">{{ $estado->titulo }}</option>
			                    @endforeach
			            </select>
				    </div>
			    </div>
           		<div class="form-group">
			      	<label>Nome</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend bg-transparent">
			        	</div>
			        	<input id="nome" name="nome" value="{{ $edital->nome }}" type="text" class="form-control form-control-lg border-left-0" placeholder="Nome do edital" required>
			      	</div>
			    </div>
			    <div class="form-group">
			      	<label>Número</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend bg-transparent">
			        	</div>
			        	<input id="numero" name="numero" value="{{ $edital->numero }}" type="text" class="form-control form-control-lg border-left-0" placeholder="Número do edital" required>
			      	</div>
			    </div>
			    <div class="form-group">
			      	<label>Bolsas</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend bg-transparent">
			        	</div>
			        	<input id="bolsas" name="bolsas" value="{{ $edital->qtd_bolsas }}" type="text" class="form-control form-control-lg border-left-0" placeholder="Número de bolsas" required>
			      	</div>
			    </div>
			    <div class="form-group">
			      	<label>Fim Inscrição</label>
			      	<input type="date" value="{{ $edital->fim_inscricao->format('Y-m-d') }}" id="fim_inscricao" name="fim_inscricao" class="form-control">
			    </div>
			    <div class="form-group">
				    <label>Anexar Edital</label>
				    <input type="file" id="anexo" name="anexo" class="form-control" >
				</div>

				<div class="mt-3">
					<div class="form-group">
				  		<div class="input-group">
				    		<button type="submit" class="btn btn-primary ml-auto">
				      			{{ __('Atuaizar Dados') }}
				    		</button>
				  		</div>
					</div>
				</div>
        </form>


		</div>
	</div>
</div>

@endsection

