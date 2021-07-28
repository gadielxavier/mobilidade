@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Detalhes Recurso</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="card">
    	<div class="card-body" style="background-color:powderblue;">
    		<h4 class="card-title">{{ $recurso->candidato->nome }}</h4>
    		<p>
    			<pre>{{ $recurso->description }}</pre>
    		</p>
      	</div>
     </div>

     @if($recurso->replied)
     <div class="card">
    	<div class="card-body">
    		<h4 class="card-title">Aeri</h4>
    		<p>
    			<pre>{{ $resposta->description }}</pre>
    		</p>
      	</div>
     </div>
     @else
     <div class="card">
    	<div class="card-body">
    		<h4 class="card-title">Resposta</h4>
    		<p>
    			O recurso ainda não foi respondido
    		</p>
      	</div>
     </div>
     @endif

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