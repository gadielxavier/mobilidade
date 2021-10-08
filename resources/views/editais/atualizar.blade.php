  @extends('layouts.site')

  @section('content')

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h4 class="font-weight-bold mb-0">Atualizar Edital</h4>
          </div>
        </div>
      </div>
    </div>

  	<div class="card">
  		<div class="card-body">
        <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('editais.update', $edital->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Nome</label>
                <input id="nome" name="nome" value="{{ $edital->nome }}" type="text" class="form-control" placeholder="Nome do edital" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Número</label>
                <input id="numero" name="numero" value="{{ $edital->numero }}" type="text" class="form-control" placeholder="Número do edital" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Bolsas</label>
                <input id="bolsas" name="bolsas" value="{{ $edital->qtd_bolsas }}" type="text" class="form-control" placeholder="Número de bolsas" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Status:</label>
                <select id="status" name="status" class="form-control">
                  @foreach($status as $estado)
                    @if($edital->status->id == $estado->id )
                      <option value="{{ $edital->status->id }}" selected>{{ $edital->status->titulo }}</option>
                    @else
                      <option value="{{  $estado->id }}">{{ $estado->titulo }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Anexar Edital</label>
                <input type="file" id="anexo" name="anexo" class="form-control" >
              </div>
            </div>
          </div>
  				<div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Início Inscrição</label>
                <input type="date" value="{{ $edital->inicio_inscricao->format('Y-m-d') }}" id="inicio_inscricao" name="inicio_inscricao" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim Inscrição</label>
                <input type="date" value="{{ $edital->fim_inscricao->format('Y-m-d') }}" id="fim_inscricao" name="fim_inscricao" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Divulgação das inscrições homologadas</label>
                <input type="date" value="{{ $edital->homologacoes_inscricoes->format('Y-m-d') }}" id="homologacoes_inscricoes" name="homologacoes_inscricoes" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Início recurso inscrição</label>
                <input type="date" value="{{ $edital->inicio_recurso_inscricao->format('Y-m-d') }}" id="inicio_recurso_inscricao" name="inicio_recurso_inscricao" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim recurso inscrição</label>
                <input type="date" value="{{ $edital->fim_recurso_inscricao->format('Y-m-d') }}" id="fim_recurso_inscricao" name="fim_recurso_inscricao" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Divulgação Final da Homologação após período de recurso</label>
                <input type="date" value="{{ $edital->homologacao_final->format('Y-m-d') }}" id="homologacao_final" name="homologacao_final" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Início da Avaliação de Proficiência</label>
                <input type="date" value="{{ $edital->inicio_proeficiencia->format('Y-m-d') }}" id="inicio_proeficiencia" name="inicio_proeficiencia" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim da Avaliação de Proficiência</label>
                <input type="date" value="{{ $edital->fim_proeficiencia->format('Y-m-d') }}" id="fim_proeficiencia" name="fim_proeficiencia" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Divulgação do resultado dos alunos aprovados na 1ª fase</label>
                <input type="date" value="{{ $edital->aprovados_primeira_fase->format('Y-m-d') }}" id="aprovados_primeira_fase" name="aprovados_primeira_fase" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Início recurso da primeira fase</label>
                <input type="date" value="{{ $edital->inicio_recurso_primeira_fase->format('Y-m-d') }}" id="inicio_recurso_primeira_fase" name="inicio_recurso_primeira_fase" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim recurso da primeira fase</label>
                <input type="date" value="{{ $edital->fim_recurso_primeira_fase->format('Y-m-d') }}" id="fim_recurso_primeira_fase" name="fim_recurso_primeira_fase" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Resultado final da primeira fase</label>
                <input type="date" value="{{ $edital->resultado_final_primeira_fase->format('Y-m-d') }}" id="resultado_final_primeira_fase" name="resultado_final_primeira_fase" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Início da Avaliação e Classificação dos candidatos pela Comissão Interna de Cooperação Internacional – CCInt</label>
                <input type="date" value="{{ $edital->inicio_ccint->format('Y-m-d') }}" id="inicio_ccint" name="inicio_ccint" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim da Avaliação e Classificação dos candidatos pela Comissão Interna de Cooperação Internacional – CCInt</label>
                <input type="date" value="{{ $edital->fim_ccint->format('Y-m-d') }}" id="fim_ccint" name="fim_ccint" class="form-control" required>	       
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Resultado da 2ª fase por ordem de classificação</label>
                <input type="date" value="{{ $edital->resultado_segunda_fase->format('Y-m-d') }}" id="resultado_segunda_fase" name="resultado_segunda_fase" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Início recurso da segunda fase</label>
                <input type="date" value="{{ $edital->inicio_recurso_segunda_fase->format('Y-m-d') }}" id="inicio_recurso_segunda_fase" name="inicio_recurso_segunda_fase" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim recurso da segunda fase</label>
                <input type="date" value="{{ $edital->fim_recurso_segunda_fase->format('Y-m-d') }}" id="fim_recurso_segunda_fase" name="fim_recurso_segunda_fase" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Resultado final da segunda fase</label>
                <input type="date" value="{{ $edital->resultado_final_segunda_fase->format('Y-m-d') }}" id="resultado_final_segunda_fase" name="resultado_final_segunda_fase" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Reunião de Esclarecimentos e orientações para preenchimento dos Formulários da Universidade Selecionada</label>
                <input type="date" value="{{ $edital->reuniao_esclarecimentos->format('Y-m-d') }}" id="reuniao_esclarecimentos" name="reuniao_esclarecimentos" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Início para entrega dos Formulários de Candidatura, e respectiva documentação na AERI.</label>
                <input type="date" value="{{ $edital->inicio_entrega_documentos->format('Y-m-d') }}" id="inicio_entrega_documentos" name="inicio_entrega_documentos" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim para entrega dos Formulários de Candidatura.</label>
                <input type="date" value="{{ $edital->fim_entrega_documentos->format('Y-m-d') }}" id="fim_entrega_documentos" name="fim_entrega_documentos" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Início da avaliação dos documentos pelos Colegiados de Cursos</label>
                <input type="date" value="{{ $edital->inicio_avaliacao_documentos->format('Y-m-d') }}" id="inicio_avaliacao_documentos" name="inicio_avaliacao_documentos" class="form-control" required>   
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim da avaliação dos documentos pelos Colegiados de Cursos</label>
                <input type="date" value="{{ $edital->fim_avaliacao_documentos->format('Y-m-d') }}" id="fim_avaliacao_documentos" name="fim_avaliacao_documentos" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Envio das Candidaturas para as IES anfitriãs</label>
                <input type="date" value="{{ $edital->envio_candidaturas->format('Y-m-d') }}" id="envio_candidaturas" name="envio_candidaturas" class="form-control" required> 
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Início para apresentação e recepção das cartas de aceite das IES de acolhimento</label>
                <input type="date" value="{{ $edital->inicio_recepcao_carta->format('Y-m-d') }}" id="inicio_recepcao_carta" name="inicio_recepcao_carta" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Fim para apresentação e recepção das cartas de aceite das IES de acolhimento</label>
                <input type="date" value="{{ $edital->fim_recepcao_carta->format('Y-m-d') }}" id="fim_recepcao_carta" name="fim_recepcao_carta" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Divulgação dos resultados da 3ª fase</label>
                <input type="date" value="{{ $edital->divulgacao_resultado_terceira_fase->format('Y-m-d') }}" id="divulgacao_resultado_terceira_fase" name="divulgacao_resultado_terceira_fase" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Período para aquisição de visto, seguro, passagens e exames</label>
                <input type="date" value="{{ $edital->inicio_aquisicoes->format('Y-m-d') }}" id="inicio_aquisicoes" name="inicio_aquisicoes" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Início da Mobilidade Acadêmica</label>
                <input type="date" value="{{ $edital->inicio_mobilidade->format('Y-m-d') }}" id="inicio_mobilidade" name="inicio_mobilidade" class="form-control" required>
              </div>
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
                    <button  type="button" name="add" id="add" class="btn btn-success">
                      Adicionar
                    </button>
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

