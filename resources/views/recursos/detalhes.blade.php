@extends('layouts.site')

@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Detalhes Recurso</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
		    	<div class="card-body" style="background-color:powderblue;">
		    		<h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
		    		<p>
		    			<pre>{{ $recurso->description }}</pre>
		    		</p>
		      	</div>
		     </div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			@if(!$recurso->replied)
		     <div class="card">
		    	<div class="card-body">
		    		<form class="form-horizontal" method="POST" action="{{ route('resposta', $recurso->id) }}">
		    			{{ csrf_field() }}
			    		<h4 class="card-title">Resposta</h4>


			    		<div class="media mt-3 shadow-textarea">
					      <div class="media-body">
					        <div class="form-group basic-textarea rounded-corners">
					          <textarea class="form-control z-depth-1" name="description" id="description"  placeholder="Escreva aqui..." rows="10"></textarea>
					        </div>
					      </div>
					    </div>

					    <div class="form-group">
			            	<h4 class="card-title">Status Inscrição:</h4>
			            	<div class="dropdown">
			               		<select id="status" name="status" class="form-control custom-select">
			                  		<option selected value="4">Inscrição homologada após recurso</option>
			                    	<option value="5">Inscrição não homologada após recurso</option>
			                    	<option value="8">Candidato aprovado proficiência após recurso</option>
			                    	<option value="9">Candidato reprovado proficiência após recurso</option>
			                    	<option value="12">Candidato aprovado ccint após recurso</option>
			                    	<option value="13">Candidato reprovado ccint após recurso</option>
			              		</select>
			            	</div>
			          	</div>

					   <button type="submit"  class="btn btn-primary btn-sm">
		                {{ __('Enviar') }}
		              </button>
					</form>

		      	</div>
		     </div>
		     @else
		     <div class="card">
		    	<div class="card-body">
		    		<h4 class="card-title">Resposta</h4>
		    		<p>
		    			<pre>{{ $resposta->description }}</pre>
		    		</p>
		      	</div>
		     </div>
		     @endif
		</div>
	</div>

	<style>
		pre {
		   white-space: pre-wrap;       /* Since CSS 2.1 */
		   white-space: -moz-pre-wrap;  /* Mozilla */
		   white-space: -pre-wrap;      /* Opera 4-6 */
		   white-space: -o-pre-wrap;    /* Opera 7 */
		   word-wrap: break-word;       /* Internet Explorer */
		}
	</style>

</div>

@endsection