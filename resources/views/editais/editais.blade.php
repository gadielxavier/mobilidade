@extends('layouts.site')

@section('content')



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
		@if(session()->has('message'))
		    <div class="alert alert-success alert-dismissible fade show">
		        {{ session()->get('message') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				</button>
		    </div>
		@endif
		<div class="input-group">
                <button type="submit" data-toggle="modal" data-target="#editalModal" class="btn btn-primary ml-auto">
                  {{ __('Adicionar') }}
                </button>
              </div>

		<table class="table table-striped">
			<thead>
				<tr>
					 <th>Nome</th>
                      <th>Número</th>
                      <th>Bolsas</th>
                      <th>Encerramento Inscrição</th>
                      <th>Status</th>
				</tr>
	    </thead>
	    <tbody>
	    	<div class="scrolling-pagination">
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
			          @isset($edital->status->titulo)
			            {{ $edital->status->titulo }}
			          @endif
			        </td>
			        <td>
			          <a href="/editais/detalhes/{{ $edital->id }}"  class="btn btn-primary btn-sm"> Detalhes</a>
			        </td>
			        
			        <td>
			          	<a href="#deleteModal_{{ $edital->id }}" data-toggle="modal" class="btn btn-danger btn-sm"> Excluir</a>

			          	<div id="deleteModal_{{ $edital->id }}" class="modal fade">
			          		<div class="modal-dialog">
			          			<div class="modal-content">
			          				<div class="modal-header">
			          					<h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
			          					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			          						<span aria-hidden="true">×</span>
			          					</button>
			          				</div>
			          				<div class="modal-body">
			          					<form class="form-horizontal" method="POST" action="editais/detalhes/delete/{{ $edital->id }}">
					                      {{ csrf_field() }}
					                      <input type="hidden" name="_method" value="DELETE">
					                      <h6>Você tem certeza que deseja excluir esta edital?</h6>

					                    	<div class="modal-footer">
					                      		<div class="form-group">
					                        		<button type="submit" class="btn btn-primary">
					                          			Sim
					                        		</button>
					                        		<button type="button" data-dismiss="modal" class="btn btn-outline-primary">
					                          			Não
					                        		</button>
					                      		</div>
					                    	</div>
					      				</form>
					      			</div>
					      		</div>
					      	</div>
					    </div>
					</td>
					
			      </tr>
		      @endforeach
		    </div>
	    </tbody>
	  </table>
	  {{ $editais->links("pagination::bootstrap-4") }}
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
					<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
			          <label>Nome</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome do edital" required>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>Número</label>
			          <div class="input-group">
			            <div class="input-group-prepend bg-transparent">
			            </div>
			            <input id="numero" name="numero" type="text" class="form-control" placeholder="Número do edital" required>
			            @if ($errors->has('nome'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nome') }}</strong>
                            </span>
                        @endif
			          </div>
			        </div>
			        <div class="form-group">
			          <label>Bolsas</label>
			          	<div class="input-group">
			            	<div class="input-group-prepend bg-transparent">
			            	</div>
			        		<input id="bolsas" name="bolsas" type="text" class="form-control" placeholder="Número de bolsas" required>
			        	</div>
			        </div>
			        <div class="form-group">
			        	<label>Início Inscrição</label>
			          	<input type="date" id="inicio_inscricao" name="inicio_inscricao" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim Inscrição</label>
			          	<input type="date" id="fim_inscricao" name="fim_inscricao" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Divulgação das inscrições homologadas</label>
			          	<input type="date" id="homologacoes_inscricoes" name="homologacoes_inscricoes" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início recurso inscrição</label>
			          	<input type="date" id="inicio_recurso_inscricao" name="inicio_recurso_inscricao" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim recurso inscrição</label>
			          	<input type="date" id="fim_recurso_inscricao" name="fim_recurso_inscricao" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Divulgação Final da Homologação após período de recurso</label>
			          	<input type="date" id="homologacao_final" name="homologacao_final" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início da Avaliação de Proficiência</label>
			          	<input type="date" id="inicio_proeficiencia" name="inicio_proeficiencia" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim da Avaliação de Proficiência</label>
			          	<input type="date" id="fim_proeficiencia" name="fim_proeficiencia" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Divulgação do resultado dos alunos aprovados na 1ª fase</label>
			          	<input type="date" id="aprovados_primeira_fase" name="aprovados_primeira_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início recurso da primeira fase</label>
			          	<input type="date" id="inicio_recurso_primeira_fase" name="inicio_recurso_primeira_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim recurso da primeira fase</label>
			          	<input type="date" id="fim_recurso_primeira_fase" name="fim_recurso_primeira_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Resultado final da primeira fase</label>
			          	<input type="date" id="resultado_final_primeira_fase" name="resultado_final_primeira_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início da Avaliação e Classificação dos candidatos pela Comissão Interna de Cooperação Internacional – CCInt</label>
			          	<input type="date" id="inicio_ccint" name="inicio_ccint" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim da Avaliação e Classificação dos candidatos pela Comissão Interna de Cooperação Internacional – CCInt</label>
			          	<input type="date" id="fim_ccint" name="fim_ccint" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Resultado da 2ª fase por ordem de classificação</label>
			          	<input type="date" id="resultado_segunda_fase" name="resultado_segunda_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início recurso da segunda fase</label>
			          	<input type="date" id="inicio_recurso_segunda_fase" name="inicio_recurso_segunda_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim recurso da segunda fase</label>
			          	<input type="date" id="fim_recurso_segunda_fase" name="fim_recurso_segunda_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Resultado final da segunda fase</label>
			          	<input type="date" id="resultado_final_segunda_fase" name="resultado_final_segunda_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Reunião de Esclarecimentos e orientações para preenchimento dos Formulários da Universidade Selecionada</label>
			          	<input type="date" id="reuniao_esclarecimentos" name="reuniao_esclarecimentos" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início para entrega dos Formulários de Candidatura, e respectiva documentação na AERI.</label>
			          	<input type="date" id="inicio_entrega_documentos" name="inicio_entrega_documentos" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim para entrega dos Formulários de Candidatura, e respectiva documentação na AERI.</label>
			          	<input type="date" id="fim_entrega_documentos" name="fim_entrega_documentos" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início da avaliação dos documentos pelos Colegiados de Cursos</label>
			          	<input type="date" id="inicio_avaliacao_documentos" name="inicio_avaliacao_documentos" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim da avaliação dos documentos pelos Colegiados de Cursos</label>
			          	<input type="date" id="fim_avaliacao_documentos" name="fim_avaliacao_documentos" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Envio das Candidaturas para as IES anfitriãs</label>
			          	<input type="date" id="envio_candidaturas" name="envio_candidaturas" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início para apresentação e recepção das cartas de aceite das IES de acolhimento</label>
			          	<input type="date" id="inicio_recepcao_carta" name="inicio_recepcao_carta" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Fim para apresentação e recepção das cartas de aceite das IES de acolhimento</label>
			          	<input type="date" id="fim_recepcao_carta" name="fim_recepcao_carta" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Divulgação dos resultados da 3ª fase</label>
			          	<input type="date" id="divulgacao_resultado_terceira_fase" name="divulgacao_resultado_terceira_fase" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Período para aquisição de visto, seguro, passagens e exames</label>
			          	<input type="date" id="inicio_aquisicoes" name="inicio_aquisicoes" class="form-control" required>
			        </div>
			        <div class="form-group">
			        	<label>Início da Mobilidade Acadêmica</label>
			          	<input type="date" id="inicio_mobilidade" name="inicio_mobilidade" class="form-control" required>
			        </div>
			        <div class="form-group">
		                <label>Anexar Edital</label>
		                <div class="form-group{{ $errors->has('anexo') ? ' has-error' : '' }}">
		                  <input id="fileinput" name="anexo" type="file" style="display:none;"/ required>
		                  @if ($errors->has('anexo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('anexo') }}</strong>
                            </span>
                          @endif
		                  <button class="btn btn-primary" id="falseinput">Escolher arquivo</button>
		                  <span class="input-group-prepend bg-transparent" id="selected_filename">Nenhum arquivo selecionado</span>
		                </div>
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
