@extends('layouts.site')

@section('content')

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div style="display:inline-block;width:100%;overflow-y:auto;">
      <ul class="timeline timeline-horizontal">
        <li class="timeline-item">
          <div class="timeline-badge primary"><i class="ti-pencil-alt mx-0"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->inicio_inscricao))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Período de inscrição</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->inicio_inscricao))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_inscricao->format('d/m/Y') }} à {{ $edital->fim_inscricao->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-layers-alt"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->homologacoes_inscricoes))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação das inscrições homologadas</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->homologacoes_inscricoes))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->homologacoes_inscricoes->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge info"><i class="ti-info-alt mx-0"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->inicio_recurso_inscricao))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Prazo para recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->inicio_recurso_inscricao))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_recurso_inscricao->format('d/m/Y') }} à {{ $edital->fim_recurso_inscricao->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge danger"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->homologacao_final))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação Final da Homologação após período de recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->homologacao_final))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->homologacao_final->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge warning"><i class="ti-pencil-alt"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->inicio_proeficiencia))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Realização da Avaliação de Proficiência</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->inicio_proeficiencia))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_proeficiencia->format('d/m/Y') }} à {{ $edital->fim_proeficiencia->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->aprovados_primeira_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação do resultado dos alunos aprovados na 1a fase</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->aprovados_primeira_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->aprovados_primeira_fase->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge danger"><i class="ti-info-alt"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->inicio_recurso_primeira_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Prazo para recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->inicio_recurso_primeira_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->inicio_recurso_primeira_fase->format('d/m/Y') }} à {{ $edital->fim_recurso_primeira_fase->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->resultado_final_primeira_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação do Resultado Final da 1a fase após período de recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->resultado_final_primeira_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>Até {{ $edital->resultado_final_primeira_fase }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge warning"><i class="ti-pencil"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->fim_ccint))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Avaliação e Classificação dos candidatos pela Comissão Interna de Cooperação Internacional</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->fim_ccint))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_ccint->format('d/m/Y') }} à {{ $edital->fim_ccint->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->resultado_segunda_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Resultado da 2a fase por ordem de classificação</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->resultado_segunda_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->resultado_segunda_fase->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge danger"><i class="ti-info-alt"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->fim_recurso_segunda_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Prazo para recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->fim_recurso_segunda_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_recurso_segunda_fase->format('d/m/Y') }} à {{ $edital->fim_recurso_segunda_fase->format('d/m/Y') }} </p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->resultado_final_segunda_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação Final do Resultado da 2a fase após período de recurso</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->resultado_final_segunda_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->resultado_final_segunda_fase->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge info"><i class="ti-agenda"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->reuniao_esclarecimentos))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Reunião de Esclarecimentos e orientações para preenchimento dos Formulários da Universidade Selecionada</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->reuniao_esclarecimentos))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->reuniao_esclarecimentos->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge warning"><i class="ti-check-box"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->fim_entrega_documentos))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Prazo para entrega dos Formulários de Candidatura, e respectiva documentação na AERI.</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->fim_entrega_documentos))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_entrega_documentos->format('d/m/Y') }} à {{ $edital->fim_entrega_documentos->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge"><i class="ti-calendar"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->fim_avaliacao_documentos))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Prazo para avaliação dos documentos pelos Colegiados de Cursos.</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->fim_avaliacao_documentos))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>De {{ $edital->inicio_avaliacao_documentos->format('d/m/Y') }} à {{ $edital->fim_avaliacao_documentos->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-envelope"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->envio_candidaturas))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Envio das Candidaturas para as IES anfitriãs.</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->envio_candidaturas))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->envio_candidaturas->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge warning"><i class="ti-email"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->fim_recepcao_carta))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Data limite para apresentação e recepção das cartas de aceite das IES de acolhimento.</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->fim_recepcao_carta))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->inicio_recepcao_carta->format('d/m/Y') }} à {{ $edital->fim_recepcao_carta->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge info"><i class="ti-announcement"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->divulgacao_resultado_terceira_fase))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Divulgação dos resultados da 3a fase.</h4>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->divulgacao_resultado_terceira_fase))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
              <p>{{ $edital->divulgacao_resultado_terceira_fase->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge danger"><i class="ti-pulse"></i></div>
          @if (\Carbon\Carbon::now()->lt($edital->inicio_aquisicoes))
          <div class="timeline-panel">
          @else
          <div class="timeline-panel transparent">
          @endif
            <div class="timeline-heading">
              <h4 class="timeline-title">Período para:</h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>1) Aquisição de visto no consulado</small></p>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2) Seguro Saúde</small></p>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>3) Aquisição de Passagens Aéreas</small></p>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>4) Realização de exames médicos</small></p>
            </div>
            <div class="timeline-body">
              @if (\Carbon\Carbon::now()->lt($edital->inicio_aquisicoes))
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              @endif
                <p>A partir de {{ $edital->inicio_aquisicoes->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
        <li class="timeline-item">
          <div class="timeline-badge success"><i class="ti-face-smile"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Início da Mobilidade Acadêmica </h4>
            </div>
            <div class="timeline-body">
                <button type="button" autofocus class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <p>A partir de {{ $edital->inicio_mobilidade->format('d/m/Y') }}</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    </div>
  </div>
</div>

<div class="ccontainer-fluid">
	<div class="card">
		<div class="card-body">
  		<h4 class="card-title">Acompanhar Inscrição</h4>
      <p class="card-description">Status</p>
      <div class="form-group">
        <p>{{ $candidatura->status->titulo }}</p>

        @if( $candidatura->status->id ==  3 || $candidatura->status->id == 11 )
        <p class="card-description">Entrar com Recurso</p>
          <button type="submit" data-toggle="modal" data-target="#editalModal"  class="btn btn-primary btn-sm">
            {{ __('Recurso') }}
          </button>
        @endif
      </div>

      <div class="form-group">
        <p class="card-description">Próximos passos</p>
        @if( $candidatura->status->id ==  1 )
          <p>
            Sua inscrição está sendo processada. O resultado das homologações sera divulgado dia {{ $edital->homologacoes_inscricoes->format('d/m/Y') }}
          </p>
        @endif

        @if( $candidatura->status->id ==  2 )
          <p>
            Os estudantes deferidos estão habilitados a prosseguirem com o processo de seleção. Informamos que as provas (Oral e escrita) de proficiência referentes ao Edital {{ $edital->nome }} / {{ $edital->numero }} de Mobilidade Estudantil ocorrerão, impreterivelmente, de acordo com o cronograma publicado no site "http://aeri.uefs.br/"
          </p>
        @endif

        @if( $candidatura->status->id ==  3 )
          <p>
            O resultado pós recurso será divulgado no dia {{ $edital->homologacao_final->format('d/m/Y') }}, junto com as orientações para a prova de proficiência linguística. 
          </p>
        @endif

        @if( $candidatura->status->id ==  4 )
          <p>
            Os estudantes deferidos estão habilitados a prosseguirem com o processo de seleção. Informamos que as provas (Oral e escrita) de proficiência referentes ao Edital {{ $edital->nome }} / {{ $edital->numero }} de Mobilidade Estudantil ocorrerão, impreterivelmente, de acordo com o cronograma publicado no site "http://aeri.uefs.br/"
          </p>
        @endif

        @if( $candidatura->status->id ==  5 )
          <p>
            Candidato eliminado.
          </p>
        @endif

        @if( $candidatura->status->id ==  6 )
          <p>
            Os candidatos que possuem opções validadas pelo teste de proficiência estão aptos para prosseguirem para a 2ª fase do edital {{ $edital->nome }}  {{ $edital->numero }}  avaliação e classificação dos candidatos pela Comissão Interna de Cooperação Internacional - CCint.
          </p>
        @endif

        @if( $candidatura->status->id ==  7 )
          <p>
            O resultado pós recurso será divulgado no dia {{ $edital->resultado_final_primeira_fase->format('d/m/Y') }}. 
          </p>
        @endif

        @if( $candidatura->status->id ==  8 )
          <p>
            Os candidatos que possuem opções validadas pelo teste de proficiência estão aptos para prosseguirem para a 2ª fase do edital {{ $edital->nome }}  {{ $edital->numero }}  avaliação e classificação dos candidatos pela Comissão Interna de Cooperação Internacional - CCint.
          </p>
        @endif

        @if( $candidatura->status->id ==  9 )
          <p>
            Candidato eliminado.
          </p>
        @endif

        @if( $candidatura->status->id ==  10 )
          <p>
            Convocamos os candidatos aprovados para a reunião obrigatória no dia {{ $edital->reuniao_esclarecimentos->format('d/m/Y') }}, em local a ser informado por e-mail, visando esclarecimentos e orientações para preenchimento dos Formulários de candidatura das IES de destino.
          </p>

            @if($edital->status_edital_id == 12)
            <p>
              @if($candidatura->ies_anfitria != null)
                Candidato aprovado na IES: {{ $candidatura->ies_anfitria }}.
              @else
                Candidato não foi aprovado em nenhuma das 3 opções de ies. Entrar em contato com a Aeri nas próximas 48 horas para mudança de IES.
              @endif
            </p>
            @endif 
        @endif

        @if( $candidatura->status->id ==  11 )
          <p>
            Prazo de recurso: {{ $edital->fim_recurso_segunda_fase->format('d/m/Y') }}.
          </p>

          <p>
              O resultado pós recurso será divulgado no dia {{ $edital->resultado_final_segunda_fase->format('d/m/Y') }}
          </p>
        @endif

        @if( $candidatura->status->id ==  12 )
          <p>
            Convocamos os candidatos aprovados para a reunião obrigatória no dia {{ $edital->reuniao_esclarecimentos->format('d/m/Y') }}, em local a ser informado por e-mail, visando esclarecimentos e orientações para preenchimento dos Formulários de candidatura das IES de destino. 
          </p>

          <p>
            @if($candidatura->ies_anfitria != null)
              Candidato aprovado na universidade {{ $candidatura->ies_anfitria }}.
            @else
              Candidato não foi aprovado em nenhuma das 3 opções de ies. Entrar em contato com a Aeri nas próximas 48 horas para mudança de ies.
            @endif
          </p>

        @endif

        @if( $candidatura->status->id ==  13 )
          <p>
            Candidato eliminado.
          </p>
        @endif

        @if( $candidatura->status->id ==  14 )
          @if($avaliacao != null && $avaliacao->posicao != '0')
          <p>
            Os estudantes acima relacionados que receberam carta de aceite estão aptos para prosseguir com a aquisição/realização de: visto, seguro saúde, passagens aéreas, exames médicos. O prazo para entrega de documentos na AERI (cópias: guia de matrícula, RG, CPF, visto, PB4, comprovante de conta corrente) para assinatura do contrato da bolsa intercâmbio é até o dia {{ $edital->inicio_aquisicoes->format('d/m/Y') }}
          </p>
          @endif
        @endif

        @if( $candidatura->status->id ==  15 )
          @if($avaliacao != null && $avaliacao->posicao != '0')
          <p>
            Candidato eliminado.
          </p>
          @endif
        @endif

        @if( $candidatura->status->id ==  16 )
          <p>
            O recurso está sendo processado. 
          </p>
        @endif

        @if( $candidatura->status->id ==  17 )
          <p>
           Finalize a inscrição para ela ser processada. 
          </p>
        @endif

        @if( $candidatura->status->id ==  18 )
          <p>
            Candidato não foi aprovado em nenhuma das 3 opções de ies. Entrar em contato com a Aeri nas próximas 48 horas para mudança de IES. 
          </p>
        @endif
        
      </div> 
      <div class="form-group">
        @if(isset($recursos[0]))
          <p class="card-description">Recursos</p>
          <table class="table table-striped">
              <tbody>
              @foreach ($recursos as $recurso)
                  <tr>
                    <td>
                        @isset($recurso->candidato->id)
                          @if(strlen($recurso->description) > 15 )
                            {{ substr($recurso->description,0,15).('...')}}
                          @else
                            {{ $recurso->description }}
                          @endif 
                        @endif
                    </td>
                    <td> 
                        @isset($recurso->edital->id)
                          {{ $recurso->created_at->format('d/m/Y  H:i:s') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('candidaturas.recurso', $recurso->id) }}"  class="btn btn-primary btn-sm"> Visualizar</a>
                    </td>
                </tr>
               </tbody>
            @endforeach
           </table>
        @endif
      </div>     
      <div class="form-group">
        @if($candidatura->certificado_proficiencia1 != '0')
          <p class="card-description">Certificado de Proficiência</p>
          <a  href="{{ route('candidaturas.certificado1', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
            Visualizar
          </a>
        @endif
        @if($candidatura->certificado_proficiencia2 != '0')
          <p class="card-description">Certificado de Proficiência 2</p>
          <a  href="{{ route('candidaturas.certificado2', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
            Visualizar
          </a>
        @endif
        @if($candidatura->certificado_proficiencia3 != '0')
          <p class="card-description">Certificado de Proficiência 3</p>
          <a  href="{{ route('candidaturas.certificado3', $candidatura->id) }}" class="btn btn-primary btn-sm" target="_blank">
            Visualizar
          </a>
        @endif
      </div>
		</div>
	</div>

  <!-- Modal-->
  <div class="modal fade" id="editalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Recurso</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('recurso', $candidatura->id) }}">
            {{ csrf_field() }}
              <div>
                <p>
                  Qual o motivo para entrada do recurso?
                </p>
                <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                
              </div>
              <div class="modal-footer">
                <div class="mt-3">
                  <div class="form-group">
                    <div class="input-group">
                      <button type="submit"  class="btn btn-primary btn-sm button-prevent-multiple-submits">
                        {{ __('Enviar') }}
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
</div>

@endsection