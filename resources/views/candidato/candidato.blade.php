@extends('layouts.site')

@section('content')

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Meus dados</h4>
      <p class="card-description">
        Atualizar seus dados pessoais
      </p>

      @isset($candidato)
        <form class="form-prevent-multiple-submits" method="POST" action="{{url('candidato/update')}}" enctype="multipart/form-data">
           {!! csrf_field() !!}
          <div class="form-group{{ $errors->has('foto_perfil') ? ' has-error' : '' }}">
              <label>Foto 3/4</label>
              <a  href="candidato/foto/{{ $candidato->id }}" target="_blank">
                  Visualizar
              </a>
              <input type="file" accept="image/*" id="foto_perfil" name="foto_perfil" class="form-control">
              @if ($errors->has('foto_perfil'))
              <span class="help-block">
                <strong>{{ $errors->first('foto_perfil') }}</strong>
              </span>
              @endif
          </div>  
          <div class="form-group">
            <label>Nome Completo</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-user text-primary"></i>
                </span>
              </div>
              <input id="name" value="{{ $candidato->nome }}" name="name" type="text" class="form-control form-control-lg border-left-0" placeholder="Seu Nome Completo" required>
            </div>
          </div>
          <div class="form-group">
             <label>Sexo</label>
                <select id="sexo" name="sexo" class="form-control custom-select" placeholder="Selecione seu Sexo">
                    <option selected>{{ $candidato->sexo }}</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
          </div>
          <div class="form-group">
            <label>Matrícula</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-id-badge text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->matricula }}" id="matricula" name="matricula" class="form-control form-control-lg border-left-0" placeholder="Matrícula" required>
            </div>
          </div>
          <div class="form-group">
            <label>CPF</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-credit-card text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->cpf }}" id="cpf" name="cpf" class="form-control form-control-lg border-left-0" placeholder="CPF" required>
            </div>
          </div>
          <div class="form-group">
            <label>RG</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-id-badge text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->rg }}" id="rg" name="rg" class="form-control form-control-lg border-left-0" required>
            </div>
          </div>
          <div class="form-group">
            <label>Orgão Emissor</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-stamp text-primary"></i>
                </span>
              </div>
              <input id="emissor" value="{{ $candidato->orgao_expedidor }}" name="emissor" type="text" class="form-control form-control-lg border-left-0" required>
            </div>
          </div>
          <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" value="{{ $candidato->data_nascimento }}" id="data" name="data" class="form-control" v-model="item.dan_data_documento">
          </div>
          <div class="form-group">
            <label>Curso</label>
            <div class="dropdown">
               <select id="curso" name="curso" class="form-control custom-select">
                  <option selected>{{ $candidato->curso }}</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->nome }}">{{ $curso->nome }}</option>
                    @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Celular</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-mobile text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->celular }}" id="phone" name="phone" class="form-control form-control-lg border-left-0" placeholder="Celular" required>
            </div>
          </div>
          <div class="mt-3">
            <div class="form-group">
              <div class="input-group">
                <button id="btnFetch" type="submit" class="btn btn-primary ml-auto button-prevent-multiple-submits">
                  {{ __('Atualizar Dados') }}
                </button>
              </div>
            </div>
          </div>
        </form>


      @else

      <form method="POST" action="{{url('candidato/store')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('foto_perfil') ? ' has-error' : '' }}">
              <label>Foto 3/4</label>
              <input type="file" accept="image/*" id="foto_perfil" name="foto_perfil" class="form-control" required autofocus>
              @if ($errors->has('foto_perfil'))
              <span class="help-block">
                <strong>{{ $errors->first('foto_perfil') }}</strong>
              </span>
              @endif
        </div> 
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
          <label>Nome Completo</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-user text-primary"></i>
              </span>
            </div>
            <input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" placeholder="Seu Nome Completo" required>
            @if ($errors->has('name'))
              <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
          </div>
        </div>
        <div class="form-group">
           <label>Sexo</label>
              <select id="sexo" name="sexo" class="form-control custom-select" placeholder="Selecione seu Sexo">
                  <option selected>Selecione seu sexo...</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Feminino">Feminino</option>
                  <option value="Outro">Outro</option>
                </select>
        </div>
        <div class="form-group">
          <label>Matrícula</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-id-badge text-primary"></i>
              </span>
            </div>
            <input type="text" id="matricula" name="matricula" class="form-control form-control-lg border-left-0" placeholder="Matrícula" required>
          </div>
        </div>
        <div class="form-group">
          <label>CPF</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-credit-card text-primary"></i>
              </span>
            </div>
            <input type="text" id="cpf" name="cpf" class="form-control form-control-lg border-left-0" placeholder="CPF" required>
          </div>
        </div>
        <div class="form-group">
          <label>RG</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-id-badge text-primary"></i>
              </span>
            </div>
            <input type="text" id="rg" name="rg" class="form-control form-control-lg border-left-0" placeholder="RG" required>
          </div>
        </div>
        <div class="form-group">
          <label>Orgão Emissor</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-stamp text-primary"></i>
              </span>
            </div>
            <input id="emissor" name="emissor" type="text" class="form-control form-control-lg border-left-0" placeholder="Orgão Emissor" required>
          </div>
        </div>
        <div class="form-group">
          <label>Data de Nascimento</label>
          <input type="date" id="data" name="data" class="form-control" v-model="item.dan_data_documento">
        </div>
        <div class="form-group">
          <label>Curso</label>
          <div class="dropdown">
             <select id="curso" name="curso" class="form-control custom-select" placeholder="Selecione seu Curso">
                <option selected>Selecione seu curso...</option>
                  @foreach($cursos as $curso)
                      <option value="{{ $curso->nome }}">{{ $curso->nome }}</option>
                  @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Celular</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-mobile text-primary"></i>
              </span>
            </div>
            <input type="text" id="phone" name="phone" class="form-control form-control-lg border-left-0" placeholder="Celular" required>
          </div>
        </div>
        <div class="mt-3">
          <div class="form-group">
            <div class="input-group">
              <button type="submit" class="btn btn-primary ml-auto">
                {{ __('Atuaizar Dados') }}
              </button>
            </div>
          </div>
        </div>
      </form>

      @endif

    </div>
  </div>
</div>

@endsection


<!-- plugins:js -->

@section('scripts')


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
  <script>
      $(document).ready(function () { 
          var $seuCampoCpf = $("#cpf");
          $seuCampoCpf.mask('000.000.000-00', {reverse: true});
      });
      $(document).ready(function () { 
          var $seuCampoPhone = $("#phone");
           $seuCampoPhone.mask('(00) 00000-0000');
      });
      $(document).ready(function () { 
          var $rg = $("#rg");
           $rg.mask('99.999.999-99');
      });
      $(document).ready(function () { 
          var $matricula = $("#matricula");
           $matricula.mask('99999999');
      });
  </script>
  <script src="js/submit.js"></script>

@endsection

