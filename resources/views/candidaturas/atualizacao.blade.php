@extends('layouts.site')

@section('content')
<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
      <h4 class="card-title">Atualizar Inscrição</h4>

      <form method="POST" action="update/{{ $candidatura->id }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        @if($errors->any())
            <strong>Erro no envio!!! Tamanho máximo dos arquivos somados é de 8 Mb</strong>
        @endif
        <div class="form-group">
          <label><b>Primeira Opção Universidade</b></label>
          <div class="input-group">
            <input id="opcao1universidade" value="{{ $candidatura->primeira_opcao_universidade }}" name="opcao1universidade" type="text" class="form-control" required>
            @if ($errors->has('opcao1universidade'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao1universidade') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Primeira Opção Curso</b></label>
          <div class="input-group">
            <input id="opcao1curso" value="{{ $candidatura->primeira_opcao_curso }}" name="opcao1curso"  type="text" class="form-control" required>
            @if ($errors->has('opcao1curso'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao1curso') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Primeira Opção País</b></label>
          <div class="input-group">
            <input id="opcao1pais" value="{{ $candidatura->primeira_opcao_pais }}" name="opcao1pais" type="text" class="form-control" required>
            @if ($errors->has('opcao1pais'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao1pais') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Segunda Opção Universidade</b></label>
          <div class="input-group">
            <input id="opcao2universidade" value="{{ $candidatura->segunda_opcao_universidade }}" name="opcao2universidade" type="text" class="form-control" required>
            @if ($errors->has('opcao2universidade'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao2universidade') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Segunda Opção Curso</b></label>
          <div class="input-group">
            <input id="opcao2curso" value="{{ $candidatura->segunda_opcao_curso }}" name="opcao2curso" type="text" class="form-control" required>
            @if ($errors->has('opcao2curso'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao2curso') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Segunda Opção País</b></label>
          <div class="input-group">
            <input id="opcao2pais" value="{{ $candidatura->segunda_opcao_pais }}" name="opcao2pais" type="text" class="form-control" required>
            @if ($errors->has('opcao2pais'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao2pais') }}</strong>
            </span>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label><b>Terceira Opção Universidade</b></label>
          <div class="input-group">
            <input id="opcao3universidade" value="{{ $candidatura->terceira_opcao_universidade }}" name="opcao3universidade" type="text" class="form-control" required>
            @if ($errors->has('opcao3universidade'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao3universidade') }}</strong>
            </span>
            @endif
          </div>
        </div> 
        <div class="form-group">
          <label><b>Terceira Opção Curso</b></label>
          <div class="input-group">
            <input id="opcao3curso" value="{{ $candidatura->terceira_opcao_curso }}" name="opcao3curso" type="text" class="form-control" required>
            @if ($errors->has('opcao3curso'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao3curso') }}</strong>
            </span>
            @endif
          </div>
        </div> 
        <div class="form-group">
          <label><b>Terceira Opção País</b></label>
          <div class="input-group">
            <input id="opcao3pais" value="{{ $candidatura->terceira_opcao_pais }}" name="opcao3pais" type="text" class="form-control" required>
            @if ($errors->has('opcao3pais'))
            <span class="help-block">
              <strong>{{ $errors->first('opcao3pais') }}</strong>
            </span>
            @endif
          </div>
        </div>  
        <div class="form-group">
          <label><b>Guia de matrícula</b></label> 
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
          @if ($errors->has('matricula'))
          <span class="help-block">
            <strong>{{ $errors->first('matricula') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Histórico escolar</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="historico" name="historico" class="form-control" >
          @if ($errors->has('historico'))
          <span class="help-block">
            <strong>{{ $errors->first('historico') }}</strong>
          </span>
          @endif 
        </div>
        <div class="form-group">
          <label><b>Percentual de carga horária concluída</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="percentual" name="percentual" class="form-control" >
          @if ($errors->has('percentual'))
          <span class="help-block">
            <strong>{{ $errors->first('percentual') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Curriculum Lattes</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="curriculum" name="curriculum" class="form-control" >
          @if ($errors->has('curriculum'))
          <span class="help-block">
            <strong>{{ $errors->first('curriculum') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Plano de trabalho 1</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="trabalho1" name="trabalho1" class="form-control" >
          @if ($errors->has('trabalho1'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho1') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Plano de trabalho 2</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="trabalho2" name="trabalho2" class="form-control" >
          @if ($errors->has('trabalho2'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho2') }}</strong>
          </span>
          @endif 
        </div>
        <div class="form-group">
          <label><b>Plano de trabalho 3</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="trabalho3" name="trabalho3" class="form-control" >
          @if ($errors->has('trabalho3'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho3') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Plano de estudo 1</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="estudo1" name="estudo1" class="form-control" >
          @if ($errors->has('estudo1'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo1') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Plano de estudo 2</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="estudo2" name="estudo2" class="form-control" >
          @if ($errors->has('estudo2'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo2') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label><b>Plano de estudo 3</b></label>
          <a  href="{{ route('candidaturas.matricula', $candidatura->id) }}"  target="_blank">
            Visualizar
          </a>
          <input type="file" accept="application/pdf" id="estudo3" name="estudo3" class="form-control" >
          @if ($errors->has('estudo3'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo3') }}</strong>
          </span>
          @endif 
        </div>
        <div class="table-responsive">
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
                      <label>{{ $comprovacoes[$arquivo->comprovacao_lattes_id]->titulo }}</label>
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
              <button type="submit" class="btn btn-primary ml-auto">
                {{ __('Atualizar Dados') }}
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

@endsection