@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      		<h4 class="card-title">Atualizar Edital</h4>
      		<p class="card-description">
        		Atualizar os  dados do edital
      		</p>

			<form class="form-prevent-multiple-submits" method="POST" action="{{ route('editais.update', $edital->id) }}" enctype="multipart/form-data">
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
				<div class="table-responsive">
			             <label>Universidades</label>
			             <span id="result"></span>
			             <table class="table table-bordered" id="user_table">
			               <thead>
			                <tr>
			                  <th width="35%">Universidade</th>
			                  <th width="35%">Vagas</th>
			                  <th width="30%">Ação</th>
			                </tr>
			              </thead>
			              <tbody id="auth-rows">
			              	@foreach($universidades as $universidade)
			                  <tr>
			                    <td>
			                      <label>{{ $universidade->nome }}</label>
			                    </td>
			                    <td>
			                      <label>{{ $universidade->vagas }}</label>
			                    </td>
			                    <td>
			                      <button type="button" href="#deleteModal_{{ $universidade->id }}" data-toggle="modal" class="btn btn-danger">Remover</button>

			                      <!-- Remover Modal-->
			                      <div class="modal fade" id="deleteModal_{{ $universidade->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			                        <div class="modal-dialog">
			                          <div class="modal-content">
			                            <div class="modal-header">
			                              <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
			                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
			                                <span aria-hidden="true">×</span>
			                              </button>
			                            </div>
			                            <div class="modal-body">
			                                <h6>Você tem certeza que deseja excluir esta universidade?</h6>
			                                <div class="modal-footer">
			                                  <div class="form-group">
			                                    <a class="btn btn-primary" href="universidade/delete/{{ $universidade->id }}">
			                                      Sim
			                                    </a>
			                                    <button type="button" data-dismiss="modal" class="btn btn-outline-primary">
			                                      Não
			                                    </button>
			                                  </div>
			                                </div>
			                            </div>
			                          </div>
			                        </div>
			                      </div>

			                    </td>
			                  </tr>
			                @endforeach
						              	
			              </tbody>
			              <tfoot>
			                <tr>
			                  <td colspan="2" align="right">&nbsp;</td>
			                  <td>
			                    <button  type="button" name="add" id="add" class="btn btn-success">Adicionar</button>
			                  </td>
			                </tr>
			              </tfoot>
			            </table>
			        </div>

				<div class="mt-3">
					<div class="form-group">
				  		<div class="input-group">
				    		<button id="btnFetch" type="submit" class="btn btn-primary ml-auto button-prevent-multiple-submits">
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

@section('scripts')

	<script src="js/submit.js"></script>

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

<script type="text/javascript">
	@if (count($errors) > 0)
	$('#editalModal ').modal('show');
	@endif
</script>

<script>
$(document).ready(function(){

 var count = 1;
 var files = 0;

 dynamic_field(count);

 function dynamic_field(number)
 {
  html = '<tr>';
        html += '<td><select name="universidade[]" class="form-control custom-select" required>'
                      +"@foreach($convenios as $convenio)"
                          +"<option value='{{ $convenio->universidade }}'>{{ $convenio->universidade }}</option>"
                      +"@endforeach"
                  +'</select></td>';
        html += '<td><input type="text" name="vagas[]" class="form-control" required></td>';
        if(number > 1 )
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('#auth-rows').append(html);
            files++;
        }
 }

 $(document).on('click', '#add', function(){
  count++;
  dynamic_field(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
  files--;
 });

} ) ;
</script>

@endsection

