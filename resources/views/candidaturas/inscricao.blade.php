@extends('layouts.site')

@section('content')

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Inscrição</h4>

      <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="store/{{ $edital->id }}" enctype="multipart/form-data" id="dynamic_form">
        {{ csrf_field() }}

        @if($editalAeri->nome == $edital->nome)

          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label><b>Primeira Opção Universidade *</b></label>
                  <div class="input-group">
                    <select name="opcao1universidade" class="form-control">
                      @foreach($universidades as $universidade)
                        <option value='{{ $universidade->nome }}'>{{ $universidade->nome." (".$universidade->convenio->pais.")  (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.")
                        (".$universidade->vagas." vagas) "}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label><b>Primeira Opção Curso *</b></label>
                  <div class="input-group">
                    <input id="opcao1curso" name="opcao1curso" type="text" class="form-control">
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
                            <option value='{{ $universidade->nome }}'>{{ $universidade->nome." (".$universidade->convenio->pais.")  (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.")
                            (".$universidade->vagas." vagas) "}}</option>
                          @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label><b>Segunda Opção Curso *</b></label>
                  <div class="input-group">
                    <input id="opcao2curso" name="opcao2curso" type="text" class="form-control">
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
                            <option value='{{ $universidade->nome }}'>{{ $universidade->nome." (".$universidade->convenio->pais.")  (".$universidade->convenio->proeficiencia->lingua." ".$universidade->convenio->proeficiencia->nivel.")
                            (".$universidade->vagas." vagas) "}}</option>
                          @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label><b>Terceira Opção Curso *</b></label>
                  <div class="input-group">
                    <input id="opcao3curso" name="opcao3curso" type="text" class="form-control">
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
                              <option value='{{ $departamento->id }}'>{{ $departamento->nome }}</option>
                          @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Nome do professor *</b></label>
                  <div class="input-group">
                    <input id="nome_professor_carta" name="nome_professor_carta" type="text" class="form-control">
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
                  <input type="file" accept="application/pdf" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
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
                  <label><b>Plano de trabalho 1 *</b></label>
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
                  <input type="file" accept="application/pdf" id="estudo3" name="estudo3" class="form-control" > 
                  @if ($errors->has('estudo3'))
                  <span class="help-block">
                    <strong>{{ $errors->first('estudo3') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
              <!--
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Percentual de carga horária concluída *</b></label>
                  <input type="file" accept="application/pdf" id="percentual" name="percentual" class="form-control" >
                  @if ($errors->has('percentual'))
                  <span class="help-block">
                    <strong>{{ $errors->first('percentual') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              -->
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Curriculum Lattes *</b></label>
                  <input type="file" accept="application/pdf" id="curriculum" name="curriculum" class="form-control" >
                  @if ($errors->has('curriculum'))
                  <span class="help-block">
                    <strong>{{ $errors->first('curriculum') }}</strong>
                  </span>
                  @endif 
                </div>
              </div>
            </div>

        @else

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Departamento do professor da carta de recomendação *</b></label>
                  <div class="input-group">
                    <select name="professor_departamento_id" class="form-control">
                          @foreach($departamentos as $departamento)
                              <option value='{{ $departamento->id }}'>{{ $departamento->nome }}</option>
                          @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Nome do professor *</b></label>
                  <div class="input-group">
                    <input id="nome_professor_carta" name="nome_professor_carta" type="text" class="form-control">
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
                  <input type="file" accept="application/pdf" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
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
              <!--
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Percentual de carga horária concluída *</b></label>
                  <input type="file" accept="application/pdf" id="percentual" name="percentual" class="form-control" >
                  @if ($errors->has('percentual'))
                  <span class="help-block">
                    <strong>{{ $errors->first('percentual') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              -->
              <div class="col-md-6">
                <div class="form-group">
                  <label><b>Curriculum Lattes *</b></label>
                  <input type="file" accept="application/pdf" id="curriculum" name="curriculum" class="form-control" >
                  @if ($errors->has('curriculum'))
                  <span class="help-block">
                    <strong>{{ $errors->first('curriculum') }}</strong>
                  </span>
                  @endif 
                </div>
              </div>
            </div>

        @endif
        
          <div class="table-responsive">
            <label>Outros Documentos</label>
            <span id="result"></span>
            <table class="table table-bordered" id="user_table">
              <thead>
                <tr>
                  <th width="35%">Tipo</th>
                  <th width="35%">Anexo</th>
                  <th width="30%">Ação</th>
                </tr>
              </thead>
                <tbody id="tabela_arquivos">
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                    <td>
                      <button  type="button" name="add" id="add_arquivos" class="btn btn-success">Adicionar Arquivos</button>
                    </td>
                  </tr>
                </tfoot>
            </table>
          </div>
          <br>

          <div class="table-responsive">
             <label>Comprovação Lattes</label>
             <span id="result"></span>
             <table class="table table-bordered" id="user_table">
               <thead>
                <tr>
                  <th width="35%">Tipo</th>
                  <th width="35%">Anexo</th>
                  <th width="30%">Ação</th>
                </tr>
              </thead>
              <tbody id="tabela_lattes">
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td>
                    <button  type="button" name="add" id="add" class="btn btn-success">Adicionar Comprovação Lattes</button>
                  </td>
                </tr>
              </tfoot>
            </table>
         </div>
          <div class="modal-footer">
            <input type="hidden" name="submitbutton" value="Salvar" id="submitbutton">
            <div class="form-group">
              <div class="input-group">
                <input type="submit" class="btn btn-light ml-auto button-prevent-multiple-submits" value="Salvar"  onclick="changeSubmitButtonValue('Salvar')">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="submit" class="btn btn-primary ml-auto button-prevent-multiple-submits" value="Inscrever" onclick="changeSubmitButtonValue('Inscrever')">
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

 var contador = 1;
 var arquivos = 0;

 dynamic_field(count);
 dynamic_files(count);

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
            $('#tabela_lattes').append(html);
            files++;
        }
        else if(number > 1) 
        {
          alert('Máximo de 5 comprovantes por envio. Para adicionar mais de 5 comprovantes finalize a Inscrição e depois clique em Editar')

        }
 }

 function dynamic_files(number)
 {
  html = '<tr>';
        html += '<td><select name="anexos[]" class="form-control custom-select">'
                      +"@foreach($documentos as $documento)"
                          +"<option value='{{ $documento->id }}'>{{ $documento->titulo }}</option>"
                      +"@endforeach"
                  +'</select></td>';
        html += '<td><input type="file" name="documento[]" accept="application/pdf" class="form-control"></td>';
        if(number > 1 && arquivos < 5)
        {
            html += '<td><button type="button" name="remove_arquivo" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('#tabela_arquivos').append(html);
            arquivos++;
        }
        else if(number > 1) 
        {
          alert('Máximo de 5 comprovantes por envio. Para adicionar mais de 5 comprovantes finalize a Inscrição e depois clique em Editar')

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

 $(document).on('click', '#add_arquivos', function(){
  contador++;
  dynamic_files(contador);
 });

 $(document).on('click', '.remove_arquivo', function(){
  contador--;
  $(this).closest("tr").remove();
  arquivos--;
 });

} ) ;
</script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  function changeSubmitButtonValue(value){
    $('#submitbutton').val(value);
  }
</script>

@endsection