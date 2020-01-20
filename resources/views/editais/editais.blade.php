@extends('layouts.site')

@section('content')

@if(Auth::user()->privilegio == 2)


<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Editais</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="row table-responsive">
		<div class="input-group">
                <button type="submit" data-toggle="modal" data-target="#editalModal" class="btn btn-primary ml-auto">
                  {{ __('Adicioanar') }}
                </button>
              </div>

		<table class="table table-striped">
			<thead>
				<tr>
					 <th>Nome</th>
                      <th>Número</th>
                      <th>Bolsas</th>
                      <th>Encerramento Inscrição</th>
				</tr>
	    </thead>
	    <tbody>
	      @foreach ($editais as $edital)
		      <tr>
		        <td>
		          @isset($edital->nome)
		            {{ $edital->nome }}</td>
		          @endif
		        <td> 
		          @isset($edital->numero)
		            {{ $edital->numero }}
		          @endif
		        </td>
		        <td>
		          @isset($edital->qtd_bolsas)
		            {{ $edital->qtd_bolsas }}</td>
		          @endif
		        <td> 
		          @isset($edital->fim_inscricao)
		            {{ $edital->fim_inscricao->format('d/m/Y') }}
		          @endif
		        </td>
		        <td>
		          <a href="/editais/detalhes/{{ $edital->id }}"  class="btn btn-primary btn-sm"> Detalhes</a>
		        </td>
		      </tr>
	      @endforeach
	    </tbody>
	  </table>
	</div>

</div>

<!-- Modal-->
<div class="modal fade" id="editalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar novo edital</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="editais/store" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
			          <label>Nome</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="nome" name="nome" type="text" class="form-control form-control-lg border-left-0" placeholder="Nome do edital" required>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>Número</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="numero" name="numero" type="text" class="form-control form-control-lg border-left-0" placeholder="Número do edital" required>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>Bolsas</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="bolsas" name="bolsas" type="text" class="form-control form-control-lg border-left-0" placeholder="Número de bolsas" required>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>Fim Inscrição</label>
			          <input type="date" id="fim_inscricao" name="fim_inscricao" class="form-control" v-model="item.dan_data_documento">
			        </div>
			        <div class="form-group">
		                <label>Anexar Edital</label>
		                <div class="input-group">
		                  <input id="fileinput" name="anexo" type="file" style="display:none;"/ required>
		                  <button class="btn btn-primary" id="falseinput">Escolher arquivo</button>
		                  <span class="input-group-prepend bg-transparent" id="selected_filename">Nenhum arquivo selecionado</span>
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

	
@else

<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Você não possui privilégios para acessar esta página.</h4>
	        </div>
	      </div>
	    </div>
	</div>
</div>


@endif

@endsection

@section('scripts')

<script>
  $(document).ready( function() {
    $('#falseinput').click(function(){
      $("#fileinput").click();
    });
  });
  $('#fileinput').change(function() {
    $('#selected_filename').text($('#fileinput')[0].files[0].name);
  });

</script>

@endsection
