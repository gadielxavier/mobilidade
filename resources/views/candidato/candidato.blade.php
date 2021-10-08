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
        <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{url('candidato/update')}}" enctype="multipart/form-data">
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

          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label>Nome Completo</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-user text-primary"></i>
                </span>
              </div>
              <input id="name" value="{{ $candidato->nome }}" name="name" type="text" class="form-control form-control-lg border-left-0" placeholder="Seu Nome Completo" required>
            </div>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
             <label>Sexo</label>
                <select id="sexo" name="sexo" class="form-control custom-select">
                    <option value="Masculino" @if($candidato->sexo == 'Masculino') {{'selected'}} @endif>Masculino</option>
                    <option value="Feminino" @if($candidato->sexo == 'Feminino') {{'selected'}} @endif>Feminino</option>
                    <option value="Outro" @if($candidato->sexo == 'Outro') {{'selected'}} @endif>Outro</option>
                </select>
                @if ($errors->has('sexo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sexo') }}</strong>
                    </span>
                @endif
          </div>

          <div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
            <label>Matrícula</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-id-badge text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->matricula }}" id="matricula" name="matricula" class="form-control form-control-lg border-left-0" placeholder="Matrícula" required>
            </div>
            @if ($errors->has('matricula'))
                <span class="help-block">
                    <strong>{{ $errors->first('matricula') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
            <label>CPF</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-credit-card text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->cpf }}" id="cpf" name="cpf" class="form-control form-control-lg border-left-0" placeholder="CPF" required>
            </div>
            @if ($errors->has('cpf'))
                <span class="help-block">
                    <strong>{{ $errors->first('cpf') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
            <label>RG</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-id-badge text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->rg }}" id="rg" name="rg" class="form-control form-control-lg border-left-0" required>
            </div>
            @if ($errors->has('rg'))
                <span class="help-block">
                    <strong>{{ $errors->first('rg') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('emissor') ? ' has-error' : '' }}">
            <label>Orgão Emissor</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-stamp text-primary"></i>
                </span>
              </div>
              <input id="emissor" value="{{ $candidato->orgao_expedidor }}" name="emissor" type="text" class="form-control form-control-lg border-left-0" required>
            </div>
            @if ($errors->has('emissor'))
                <span class="help-block">
                    <strong>{{ $errors->first('emissor') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">
            <label>Data de Nascimento</label>
            <input type="date" value="{{ $candidato->data_nascimento }}" id="data" name="data" class="form-control" v-model="item.dan_data_documento">
            @if ($errors->has('data'))
                <span class="help-block">
                    <strong>{{ $errors->first('data') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('curso') ? ' has-error' : '' }}">
            <label>Curso</label>
            <div class="dropdown">
               <select id="curso" name="curso" class="form-control custom-select">
                    @foreach($cursos as $curso)
                      @if($candidato->curso == $curso->nome)
                        <option selected value="{{ $curso->nome }}">{{ $curso->nome }}</option>
                      @else
                        <option value="{{ $curso->nome }}">{{ $curso->nome }}</option>
                      @endif
                    @endforeach
              </select>
            </div>
            @if ($errors->has('curso'))
                <span class="help-block">
                    <strong>{{ $errors->first('curso') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label>Celular</label>
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="ti-mobile text-primary"></i>
                </span>
              </div>
              <input type="text" value="{{ $candidato->celular }}" id="phone" name="phone" class="form-control form-control-lg border-left-0" placeholder="Celular" required>
            </div>
            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('cotista') ? ' has-error' : '' }}">
            <label>Cotista</label>
            <div class="input-group">
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cotista" id="cotista1" value="1" @if($candidato->cotista == '1') {{'checked'}} @endif>
                  <label class="form-check-label" for="cotista1">
                    Sim
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cotista" id="cotista2" value="0" @if($candidato->cotista == '0') {{'checked'}} @endif>
                  <label class="form-check-label" for="cotista2">
                    Não
                  </label>
                </div>
              </div>
            </div>
            @if ($errors->has('cotista'))
                <span class="help-block">
                    <strong>{{ $errors->first('cotista') }}</strong>
                </span>
            @endif
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

      <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{url('candidato/store')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('foto_perfil') ? ' has-error' : '' }}">
              <label>Foto 3/4</label>
              <input type="file" accept="image/*" id="foto_perfil" name="foto_perfil" class="form-control" value="{{ old('foto_perfil') }}" required autofocus>
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
            <input id="name" name="name" type="text" class="form-control form-control-lg border-left-0" placeholder="Seu Nome Completo" value="{{ old('name') }}" required>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
           <label>Sexo</label>
              <select id="sexo" name="sexo" class="form-control custom-select">
                  <option value="Masculino" @if( old('sexo') == 'Masculino') {{'selected'}} @endif>Masculino</option>
                  <option value="Feminino" @if( old('sexo') == 'Feminino') {{'selected'}} @endif>Feminino</option>
                  <option value="Outro" @if( old('sexo') == 'Outro') {{'selected'}} @endif>Outro</option>
              </select>
              @if ($errors->has('sexo'))
                  <span class="help-block">
                      <strong>{{ $errors->first('sexo') }}</strong>
                  </span>
              @endif
        </div>

        <div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
          <label>Matrícula</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-id-badge text-primary"></i>
              </span>
            </div>
            <input type="text" id="matricula" name="matricula" class="form-control form-control-lg border-left-0" placeholder="Matrícula" value="{{ old('matricula') }}" required>
          </div>
          @if ($errors->has('matricula'))
              <span class="help-block">
                  <strong>{{ $errors->first('matricula') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
          <label>CPF</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-credit-card text-primary"></i>
              </span>
            </div>
            <input type="text" id="cpf" name="cpf" class="form-control form-control-lg border-left-0" placeholder="CPF" value="{{ old('cpf') }}" required>
          </div>
          @if ($errors->has('cpf'))
              <span class="help-block">
                  <strong>{{ $errors->first('cpf') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
          <label>RG</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-id-badge text-primary"></i>
              </span>
            </div>
            <input type="text" id="rg" name="rg" class="form-control form-control-lg border-left-0" placeholder="RG" value="{{ old('rg') }}" required>
          </div>
          @if ($errors->has('rg'))
              <span class="help-block">
                  <strong>{{ $errors->first('rg') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('emissor') ? ' has-error' : '' }}">
          <label>Orgão Emissor</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-stamp text-primary"></i>
              </span>
            </div>
            <input id="emissor" name="emissor" type="text" class="form-control form-control-lg border-left-0" placeholder="Orgão Emissor" value="{{ old('emissor') }}" required>
          </div>
          @if ($errors->has('emissor'))
              <span class="help-block">
                  <strong>{{ $errors->first('emissor') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">
          <label>Data de Nascimento</label>
          <input type="date" id="data" name="data" class="form-control" v-model="item.dan_data_documento" value="{{ old('data') }}">
          @if ($errors->has('data'))
              <span class="help-block">
                  <strong>{{ $errors->first('data') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('curso') ? ' has-error' : '' }}">
          <label>Curso</label>
          <div class="dropdown">
             <select id="curso" name="curso" class="form-control custom-select">
                  @foreach($cursos as $curso)
                      <option value="{{ $curso->nome }}" @if( old('curso') == $curso->nome) {{'selected'}} @endif>{{ $curso->nome }}</option>
                  @endforeach
            </select>
          </div>
          @if ($errors->has('curso'))
              <span class="help-block">
                  <strong>{{ $errors->first('curso') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
          <label>Celular</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="ti-mobile text-primary"></i>
              </span>
            </div>
            <input type="text" id="phone" name="phone" class="form-control form-control-lg border-left-0" placeholder="Celular" value="{{ old('phone') }}" required>
          </div>
          @if ($errors->has('phone'))
              <span class="help-block">
                  <strong>{{ $errors->first('phone') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('cotista') ? ' has-error' : '' }}">
          <label>Cotista</label>
          <div class="input-group">
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cotista" id="cotista1" value="1">
                <label class="form-check-label" for="cotista1">
                  Sim
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cotista" id="cotista2" value="0" checked>
                <label class="form-check-label" for="cotista2">
                  Não
                </label>
              </div>
            </div>
          </div>
          @if ($errors->has('cotista'))
              <span class="help-block">
                  <strong>{{ $errors->first('cotista') }}</strong>
              </span>
          @endif
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
  
@endsection

