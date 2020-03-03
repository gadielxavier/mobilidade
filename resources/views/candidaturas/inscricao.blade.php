@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Inscrição</h4>

      <form class="form-horizontal" method="POST" action="store/{{ $edital->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if($errors->any())
           <strong>Erro no envio!!! Tamanho máximo dos arquivos somados é de 8 Mb</strong>
        @endif
        <div class="modal-body">
          <div class="form-group">
            <label>Primeira Opção Universidade</label>
            <div class="input-group">
              <input id="opcao1universidade" name="opcao1universidade" type="text" class="form-control" required>
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
              <input id="opcao1curso" name="opcao1curso" type="text" class="form-control" required>
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
              <input id="opcao1pais" name="opcao1pais" type="text" class="form-control" required>
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
              <input id="opcao2universidade" name="opcao2universidade" type="text" class="form-control" required>
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
              <input id="opcao2curso" name="opcao2curso" type="text" class="form-control" required>
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
              <input id="opcao2pais" name="opcao2pais" type="text" class="form-control" required>
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
              <input id="opcao3universidade" name="opcao3universidade" type="text" class="form-control" required>
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
              <input id="opcao3curso" name="opcao3curso" type="text" class="form-control" required>
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
              <input id="opcao3pais" name="opcao3pais" type="text" class="form-control" required>
              @if ($errors->has('opcao3pais'))
              <span class="help-block">
                <strong>{{ $errors->first('opcao3pais') }}</strong>
              </span>
              @endif
            </div>
          </div>  
          <div class="form-group">
            <label>Guia de matrícula</label>
            <input type="file" accept="application/pdf" accept="application/pdf" id="matricula" name="matricula" class="form-control" >
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
          <div class="modal-footer">
            <div class="form-group">
              <div class="input-group">
                <button type="submit" class="btn btn-primary ml-auto">
                  {{ __('Inscrever') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection