@extends('layouts.site')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="font-weight-bold mb-0">Minhas Inscrições</h4>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title mb-0">Minhas Inscrições</p>
            <div class="table-responsive">
              @isset($candidaturas)
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Número</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($candidaturas as $candidatura)
                    <tr>
                      <td>  
                        @isset($candidatura->edital->nome)
                          {{ $candidatura->edital->nome }}
                        @endif
                      </td>
                      <td>
                        @isset($candidatura->edital->numero)
                          {{ $candidatura->edital->numero }}
                        @endif
                      </td>
                      <td>
                        @isset($candidatura->status->titulo)
                          {{ $candidatura->status->titulo }}
                        @endif
                      </td>
                      <td>
                        <a  href="candidaturas/detalhes/{{ $candidatura->id }}" class="btn btn-success btn-sm">
                            Acompanhar
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  @else
                  <p>Você ainda não se inscreveu em nenhum edital!</p>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')

<script>

</script>

@endsection
