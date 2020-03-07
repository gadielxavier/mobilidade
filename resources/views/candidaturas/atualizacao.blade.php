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
          <label>Primeira Opção Universidade</label>
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
          <label>Primeira Opção Curso</label>
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
          <label>Primeira Opção País</label>
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
          <label>Segunda Opção Universidade</label>
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
          <label>Segunda Opção Curso</label>
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
          <label>Segunda Opção País</label>
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
          <label>Terceira Opção Universidade</label>
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
          <label>Terceira Opção Curso</label>
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
          <label>Terceira Opção País</label>
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
          <label>Guia de matrícula</label>
          <input type="file" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
          @if ($errors->has('matricula'))
          <span class="help-block">
            <strong>{{ $errors->first('matricula') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Histórico escolar</label>
          <input type="file" accept="application/pdf" id="historico" name="historico" class="form-control" >
          @if ($errors->has('historico'))
          <span class="help-block">
            <strong>{{ $errors->first('historico') }}</strong>
          </span>
          @endif 
        </div>
        <div class="form-group">
          <label>Percentual de carga horária concluída</label>
          <input type="file" accept="application/pdf" id="percentual" name="percentual" class="form-control" >
          @if ($errors->has('percentual'))
          <span class="help-block">
            <strong>{{ $errors->first('percentual') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Curriculum Lattes</label>
          <input type="file" accept="application/pdf" id="curriculum" name="curriculum" class="form-control" >
          @if ($errors->has('curriculum'))
          <span class="help-block">
            <strong>{{ $errors->first('curriculum') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Plano de trabalho 1</label>
          <input type="file" accept="application/pdf" id="trabalho1" name="trabalho1" class="form-control" >
          @if ($errors->has('trabalho1'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho1') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Plano de trabalho 2</label>
          <input type="file" accept="application/pdf" id="trabalho2" name="trabalho2" class="form-control" >
          @if ($errors->has('trabalho2'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho2') }}</strong>
          </span>
          @endif 
        </div>
        <div class="form-group">
          <label>Plano de trabalho 3</label>
          <input type="file" accept="application/pdf" id="trabalho3" name="trabalho3" class="form-control" >
          @if ($errors->has('trabalho3'))
          <span class="help-block">
            <strong>{{ $errors->first('trabalho3') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Plano de estudo 1</label>
          <input type="file" accept="application/pdf" id="estudo1" name="estudo1" class="form-control" >
          @if ($errors->has('estudo1'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo1') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Plano de estudo 2</label>
          <input type="file" accept="application/pdf" id="estudo2" name="estudo2" class="form-control" >
          @if ($errors->has('estudo2'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo2') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label>Plano de estudo 3</label>
          <input type="file" accept="application/pdf" id="estudo3" name="estudo3" class="form-control" >
          @if ($errors->has('estudo3'))
          <span class="help-block">
            <strong>{{ $errors->first('estudo3') }}</strong>
          </span>
          @endif 
        </div>
        <div id="dynamicInput">
          <div class="form-group">
          </div>
        </div>
        <input type="button" value="Adicionar Comprovação Lattes" onClick="addInput('dynamicInput');">
        <!--
        <div class="form-group">
          <label>Certificado</label>
          <input type="file" accept="application/pdf" id="certificado" name="certificado" class="form-control" >
          @if ($errors->has('certificado'))
          <span class="help-block">
            <strong>{{ $errors->first('certificado') }}</strong>
          </span>
          @endif
        </div>
      -->
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
  <script type="text/javascript">
    var counter = 1;

    function addInput(divName){

      var comprovacao = 'comprovacao'+counter;
      var categoria = 'categoria'+counter;

      var newdiv = document.createElement('div');
      newdiv.id = "div"+counter;
      newdiv.innerHTML = "Comprovação Lattes  " + (counter)
      + "<a href='#'style='color:red'  onClick='removeElement(\"" + newdiv.id + "\");'>Remover</a>" 
      + "<div class='form-group'>"
            +"<div class='dropdown'>"
              +"<label>Categoria</label>"
              +"<select  name='categoria' class='form-control custom-select'>"
                    +"@foreach($comprovacoes as $comprovacao)"
                        +"<option value='{{ $comprovacao->id }}'>{{ $comprovacao->titulo }}</option>"
                    +"@endforeach"
                +"</select>"
            +"</div>"
            +"<label>Arquivo</label>"
            +"<input type='file' accept='application/pdf' name=\"" + comprovacao + "\" class='form-control' >"
          +"</div>";
      document.getElementById(divName).appendChild(newdiv);
      counter++;

    }
    function removeElement(elementId) {
        // Removes an element from the document
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
        counter--;
    }
  </script>



@endsection