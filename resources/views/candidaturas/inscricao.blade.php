@extends('layouts.site')

@section('content')

<div class="ccontainer-fluid">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Inscrição</h4>

      <form class="form-horizontal" method="POST" action="store/{{ $edital->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <label>Primeira Opção Universidade</label>
            <div class="input-group">
              <input id="opcao1universidade" name="opcao1universidade" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Primeira Opção Curso</label>
            <div class="input-group">
              <input id="opcao1curso" name="opcao1curso" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Primeira Opção País</label>
            <div class="input-group">
              <input id="opcao1pais" name="opcao1pais" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Segunda Opção Universidade</label>
            <div class="input-group">
              <input id="opcao2universidade" name="opcao2universidade" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Segunda Opção Curso</label>
            <div class="input-group">
              <input id="opcao2curso" name="opcao2curso" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Segunda Opção País</label>
            <div class="input-group">
              <input id="opcao2pais" name="opcao2pais" type="text" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label>Terceira Opção Universidade</label>
            <div class="input-group">
              <input id="opcao3universidade" name="opcao3universidade" type="text" class="form-control" required>
            </div>
          </div> 
          <div class="form-group">
            <label>Terceira Opção Curso</label>
            <div class="input-group">
              <input id="opcao3curso" name="opcao3curso" type="text" class="form-control" required>
            </div>
          </div> 
          <div class="form-group">
            <label>Terceira Opção País</label>
            <div class="input-group">
              <input id="opcao3pais" name="opcao3pais" type="text" class="form-control" required>
            </div>
          </div>  
          <div class="form-group">
            <label>Guia de matrícula</label>
            <input type="file" id="matricula" name="matricula" class="form-control" >
          </div>
          <div class="form-group">
            <label>Histórico escolar</label>
            <input type="file" id="historico" name="historico" class="form-control" >
          </div>
          <div class="form-group">
            <label>Percentual de carga horária concluída</label>
            <input type="file" id="percentual" name="percentual" class="form-control" >
          </div>
          <div class="form-group">
            <label>Curriculum Lattes</label>
            <input type="file" id="curriculum" name="curriculum" class="form-control" > 
          </div>
          <div class="form-group">
            <label>Plano de trabalho 1</label>
            <input type="file" id="trabalho1" name="trabalho1" class="form-control" >
          </div>
          <div class="form-group">
            <label>Plano de trabalho 2</label>
            <input type="file" id="trabalho2" name="trabalho2" class="form-control" > 
          </div>
          <div class="form-group">
            <label>Plano de trabalho 3</label>
            <input type="file" id="trabalho3" name="trabalho3" class="form-control" >
          </div>
          <div class="form-group">
            <label>Plano de estudo 1</label>
            <input type="file" id="estudo1" name="estudo1" class="form-control" >
          </div>
          <div class="form-group">
            <label>Plano de estudo 2</label>
            <input type="file" id="estudo2" name="estudo2" class="form-control" >
          </div>
          <div class="form-group">
            <label>Plano de estudo 3</label>
            <input type="file" id="estudo3" name="estudo3" class="form-control" > 
          </div>
          <div class="form-group">
            <label>Certificado</label>
            <input type="file" id="certificado" name="certificado" class="form-control" >
          </div>
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