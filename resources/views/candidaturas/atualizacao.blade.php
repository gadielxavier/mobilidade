@extends('layouts.site')

@section('content')
<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      <h4 class="card-title">Atualizar Inscrição</h4>

      <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="update/{{ $candidatura->id }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        @if($errors->any())
            <strong>Erro no envio!!! Tamanho máximo dos arquivos somados é de 8 Mb</strong>
        @endif
        <div class="div">

          <div class="padding">
            <div class="row container d-flex justify-content-center">
              <div class="col-xl-12">
                <div class="card proj-progress-card">
                  <div class="card-block">
                    <div class="row">

                      @if($count >= 13)
                      <div class="col-xl-3 col-md-6">
                        <h6>Progresso</h6>
                        <div class="progress">
                          <div class="progress-bar bg-c-red" style="width:20%"></div>
                        </div>
                      </div>
                      @elseif( $count >= 9)
                      <div class="col-xl-3 col-md-6">
                          <h6>Progresso</h6>
                      <div class="progress">
                              <div class="progress-bar bg-c-yellow" style="width:40%"></div>
                          </div>
                      </div>
                      @elseif( $count >= 5)
                      <div class="col-xl-3 col-md-6">
                          <h6>Progresso</h6>
                          <div class="progress">
                              <div class="progress-bar bg-c-blue" style="width:60%"></div>
                          </div>
                      </div>
                      @elseif( $count >= 1)
                      <div class="col-xl-3 col-md-6">
                          <h6>Progresso</h6>
                       <div class="progress">
                            <div class="progress-bar bg-c-green" style="width:90%"></div>
                        </div>
                      </div>
                      @else
                      <div class="col-xl-3 col-md-6">
                          <h6>Progresso <span class="text-c-green m-l-10">100%</span></h6>
                       <div class="progress">
                            <div class="progress-bar bg-c-green" style="width:100%"></div>
                        </div>
                      </div>
                      @endif

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Primeira Opção Universidade *</b></label>
                <div class="input-group">
                  <select name="opcao1universidade" class="form-control">
                        @foreach($universidades as $universidade)
                          @if($candidatura->primeira_opcao_universidade == $universidade->nome)
                            <option value='{{ $universidade->nome }}' selected>{{ $universidade->nome." (".$universidade->vagas." vagas) (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.") "}}</option>
                          @else
                            <option value='{{ $universidade->nome }}'>{{ $universidade->nome." (".$universidade->vagas." vagas) (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.") "}}</option>
                          @endif
                        @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Primeira Opção Curso *</b></label>
                <div class="input-group">
                  <input id="opcao1curso" value="{{ $candidatura->primeira_opcao_curso }}" name="opcao1curso"  type="text" class="form-control">
                  @if ($errors->has('opcao1curso'))
                  <span class="help-block">
                    <strong>{{ $errors->first('opcao1curso') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label data-toggle="tooltip" title="Caso a universidade exija proficiência e você já tenha um certificado"><b>Certificado de proficiência 1</b></label>
                @if($candidatura->certificado_proficiencia1 != '0')
                  <a  href="{{ route('candidaturas.certificado_proficiencia1', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <div class="input-group">
                  <input type="file" accept="application/pdf" id="certificado_proficiencia1" name="certificado_proficiencia1" class="form-control">
                  @if ($errors->has('proficiencia'))
                  <span class="help-block">
                    <strong>{{ $errors->first('proficiencia') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Segunda Opção Universidade *</b></label>
                <div class="input-group">
                  <select name="opcao2universidade" class="form-control">
                        @foreach($universidades as $universidade)
                          @if($candidatura->segunda_opcao_universidade == $universidade->nome)
                            <option value='{{ $universidade->nome }}' selected>{{ $universidade->nome }}</option>
                          @else
                            <option value='{{ $universidade->nome }}'>{{ $universidade->nome }}</option>
                          @endif
                        @endforeach
                  </select>
                </div>
              </div> 
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Segunda Opção Curso *</b></label>
                <div class="input-group">
                  <input id="opcao2curso" value="{{ $candidatura->segunda_opcao_curso }}" name="opcao2curso" type="text" class="form-control">
                  @if ($errors->has('opcao2curso'))
                  <span class="help-block">
                    <strong>{{ $errors->first('opcao2curso') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label data-toggle="tooltip" title="Caso a universidade exija proficiência e você já tenha um certificado"><b>Certificado de proficiência 2</b></label>
                @if($candidatura->certificado_proficiencia2 != '0')
                  <a  href="{{ route('candidaturas.certificado_proficiencia2', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <div class="input-group">
                  <input type="file" accept="application/pdf" id="certificado_proficiencia2" name="certificado_proficiencia2" class="form-control">
                  @if ($errors->has('proficiencia'))
                  <span class="help-block">
                    <strong>{{ $errors->first('proficiencia') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Terceira Opção Universidade *</b></label>
                <div class="input-group">
                  <select name="opcao3universidade" class="form-control">
                        @foreach($universidades as $universidade)
                          @if($candidatura->terceira_opcao_universidade == $universidade->nome)
                            <option value='{{ $universidade->nome }}' selected>{{ $universidade->nome }}</option>
                          @else
                            <option value='{{ $universidade->nome }}'>{{ $universidade->nome }}</option>
                          @endif
                        @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label><b>Terceira Opção Curso *</b></label>
                <div class="input-group">
                  <input id="opcao3curso" value="{{ $candidatura->terceira_opcao_curso }}" name="opcao3curso" type="text" class="form-control">
                  @if ($errors->has('opcao3curso'))
                  <span class="help-block">
                    <strong>{{ $errors->first('opcao3curso') }}</strong>
                  </span>
                  @endif
                </div>
              </div> 
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label data-toggle="tooltip" title="Caso a universidade exija proficiência e você já tenha um certificado"><b>Certificado de proficiência 3</b></label>
                @if($candidatura->certificado_proficiencia3 != '0')
                  <a  href="{{ route('candidaturas.certificado_proficiencia3', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <div class="input-group">
                  <input type="file" accept="application/pdf" id="certificado_proficiencia3" name="certificado_proficiencia3" class="form-control">
                  @if ($errors->has('proficiencia'))
                  <span class="help-block">
                    <strong>{{ $errors->first('proficiencia') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Departamento do professor da carta de recomendação *</b></label>
                <div class="input-group">
                  <select name="professor_departamento_id" class="form-control">
                        @foreach($departamentos as $departamento)
                          @if($candidatura->professor_departamento_id == $departamento->id)
                            <option value='{{ $departamento->id }}' selected>{{ $departamento->nome }}</option>
                          @else
                            <option value='{{ $departamento->id }}'>{{ $departamento->nome }}</option>
                          @endif
                        @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Nome do professor *</b></label>
                <div class="input-group">
                  <input id="nome_professor_carta" value="{{ $candidatura->nome_professor_carta }}" name="nome_professor_carta" type="text" class="form-control">
                  @if ($errors->has('opcao3curso'))
                  <span class="help-block">
                    <strong>{{ $errors->first('opcao3curso') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Guia de matrícula *</b></label> 
                @if($candidatura->matricula != '0')
                  <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
                @if ($errors->has('matricula'))
                <span class="help-block">
                  <strong>{{ $errors->first('matricula') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Histórico escolar *</b></label>
                @if($candidatura->historico != '0')
                  <a  href="{{ route('candidaturas.historico', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="historico" name="historico" class="form-control" >
                @if ($errors->has('historico'))
                <span class="help-block">
                  <strong>{{ $errors->first('historico') }}</strong>
                </span>
                @endif 
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Percentual de carga horária concluída *</b></label>
                @if($candidatura->percentual != '0')
                  <a  href="{{ route('candidaturas.percentual', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="percentual" name="percentual" class="form-control" >
                @if ($errors->has('percentual'))
                <span class="help-block">
                  <strong>{{ $errors->first('percentual') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Curriculum Lattes *</b></label>
                @if($candidatura->curriculum != '0')
                  <a  href="{{ route('candidaturas.curriculum', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="curriculum" name="curriculum" class="form-control" >
                @if ($errors->has('curriculum'))
                <span class="help-block">
                  <strong>{{ $errors->first('curriculum') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de trabalho 1 *</b></label>
                @if($candidatura->plano_trabalho1 != '0')
                  <a  href="{{ route('candidaturas.trabalho1', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="trabalho1" name="trabalho1" class="form-control" >
                @if ($errors->has('trabalho1'))
                <span class="help-block">
                  <strong>{{ $errors->first('trabalho1') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de estudo 1 *</b></label>
                @if($candidatura->plano_estudo1 != '0')
                  <a  href="{{ route('candidaturas.estudo1', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="estudo1" name="estudo1" class="form-control" >
                @if ($errors->has('estudo1'))
                <span class="help-block">
                  <strong>{{ $errors->first('estudo1') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de trabalho 2 *</b></label>
                @if($candidatura->plano_trabalho2 != '0')
                  <a  href="{{ route('candidaturas.trabalho2', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="trabalho2" name="trabalho2" class="form-control" >
                @if ($errors->has('trabalho2'))
                <span class="help-block">
                  <strong>{{ $errors->first('trabalho2') }}</strong>
                </span>
                @endif 
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de estudo 2 *</b></label>
                @if($candidatura->plano_estudo2 != '0')
                  <a  href="{{ route('candidaturas.estudo2', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="estudo2" name="estudo2" class="form-control" >
                @if ($errors->has('estudo2'))
                <span class="help-block">
                  <strong>{{ $errors->first('estudo2') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de trabalho 3 *</b></label>
                @if($candidatura->plano_trabalho3 != '0')
                  <a  href="{{ route('candidaturas.trabalho3', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="trabalho3" name="trabalho3" class="form-control" >
                @if ($errors->has('trabalho3'))
                <span class="help-block">
                  <strong>{{ $errors->first('trabalho3') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><b>Plano de estudo 3 *</b></label>
                @if($candidatura->plano_estudo3 != '0')
                  <a  href="{{ route('candidaturas.estudo3', $candidatura->id) }}"  target="_blank">
                    Visualizar
                  </a>
                @endif
                <input type="file" accept="application/pdf" id="estudo3" name="estudo3" class="form-control" >
                @if ($errors->has('estudo3'))
                <span class="help-block">
                  <strong>{{ $errors->first('estudo3') }}</strong>
                </span>
                @endif 
              </div>
            </div>
          </div>      
          <div class="table-responsive">
              <label>Comprovação Lattes</label>
               <span id="result"></span>
               <table class="table table-bordered" id="user_table">
                 <thead>
                  <tr>
                    <th width="35%">Categoria</th>
                    <th width="35%">Arquivo</th>
                    <th width="30%">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($arquivos as $arquivo)
                    <tr>
                      <td>
                        @isset( $comprovacoes[$arquivo->comprovacao_lattes_id]->titulo )
                        <label>{{ $comprovacoes[$arquivo->comprovacao_lattes_id]->titulo }}</label>
                        @endisset
                      </td>
                      <td>
                        <a  href="candidaturas/comprovacao/{{ $arquivo->id }}" target="_blank">
                          Visualizar
                        </a>
                      </td>
                      <td>
                        <button type="button" href="#deleteModal_{{ $arquivo->id }}" data-toggle="modal" class="btn btn-danger">Remover</button>

                        <!-- Remover Modal-->
                        <div class="modal fade" id="deleteModal_{{ $arquivo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <h6>Você tem certeza que deseja excluir este comprovante?</h6>
                                  <div class="modal-footer">
                                    <div class="form-group">
                                      <a class="btn btn-primary" href="comprovante/delete/{{ $arquivo->id }}">
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
                      <button type="button" name="add" id="add" class="btn btn-success">Adicionar Comprovação Lattes</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="mt-3">
              <div class="form-group">
                <div class="input-group">
                  <button id="btnFetch" type="submit" class="btn btn-primary ml-auto button-prevent-multiple-submits">
                    {{ __('Atualizar') }}
                  </button>
                </div>
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
$(document).ready(function(){

 var count = 1;
 var files = 0;

 dynamic_field(count);

 function dynamic_field(number)
 {
  html = '<tr>';
        html += '<td><select name="categoria[]" class="form-control custom-select">'
                      +"@foreach($comprovacoes as $comprovacao)"
                          +"<option value='{{ $comprovacao->id }}'>{{ $comprovacao->titulo }}</option>"
                      +"@endforeach"
                  +'</select></td>';
        html += '<td><input type="file" name="comprovacao[]" accept="application/pdf" class="form-control"></td>';
        if(number > 1 && files < 5)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('tbody').append(html);
            files++;
        }
        else if(number > 1) 
        {
          alert('Máximo de 5 comprovantes por envio. Para adicionar mais  comprovantes finalize a Inscrição e depois clique em Editar')

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


<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script src="js/submit.js"></script>

@endsection