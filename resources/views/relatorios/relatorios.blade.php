@extends('layouts.site')

@section('content')



<div class="ccontainer-fluid">
	<div class="row">
	    <div class="col-md-12 grid-margin">
	      <div class="d-flex justify-content-between align-items-center">
	        <div>
	          <h4 class="font-weight-bold mb-0">Relatórios</h4>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="row table-responsive">
		@if(session()->has('message'))
		    <div class="alert alert-success alert-dismissible fade show">
		        {{ session()->get('message') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				</button>
		    </div>
		@endif
		<div class="input-group">
            <button type="submit" data-toggle="modal" data-target="#relatorioModal" class="btn btn-primary ml-auto">
                {{ __('Novo Relatório') }}
            </button>
		</div>
		<div class="main-panel">
        	<div class="content-wrapper">
        		<div class="row">
		            <div class="col-lg-12 grid-margin stretch-card">
		              <div class="card">
		                <div class="card-body">
		                  <h4 class="card-title">Anos</h4>
		                  <canvas id="lineChart"></canvas>
		                </div>
		              </div>
		            </div>
		        </div>
          		<div class="row">
		            <div class="col-lg-12 grid-margin grid-margin stretch-card">
		              <div class="card">
		                <div class="card-body">
		                  <h4 class="card-title">Cursos</h4>
		                  <canvas id="pieChart"></canvas>
		                </div>
		              </div>
		            </div>
		        </div>
		        <div class="row">
		            <div class="col-lg-12 grid-margin grid-margin stretch-card">
		              	<div class="card">
		                	<div class="card-body">
		                  		<h4 class="card-title">Países</h4>
		                  		<canvas id="barChart"></canvas>
		                	</div>
		              	</div>
		            </div>
          		</div>
          		<div class="row">
		            <div class="col-lg-12 grid-margin grid-margin stretch-card">
		              <div class="card">
		                <div class="card-body">
		                  <h4 class="card-title">Programas</h4>
		                  <canvas id="areaChart"></canvas>
		                </div>
		              </div>
		            </div>
		        </div>
          	</div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="relatorioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Gerar novo relatório</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="{{ route('relatorios.create') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
					  	<label>Tipo</label>
					    <div class="dropdown">
						   <select id="tipo" name="tipo" class="form-control custom-select">
						        <option selected value="1">Cursos</option>
					 			<option value="2">Países</option>
						  </select>
						</div>
					</div>

					<div class="form-group" id="auth-rows">

						
					</div>

					<div class="modal-footer">
				        <div class="mt-3">
				          <div class="form-group">
				            <div class="input-group">
				            	<button  type="button" name="add" id="add" class="btn btn-success">Próximo</button>
				            	
				              	<button type="submit" id="gerar" class="btn btn-primary ml-auto" style="display:none;">
				                	{{ __('Gerar') }}
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


@endsection

@section('scripts')

<script>
$(document).ready(function(){

	function cursos_dynamic_field()
	{
		html = '<div class="dropdown">';
		html += '<label>Curso</label><select name="dados" class="form-control custom-select" required>'
						  +"<option selected value='0'>Todos</option>"
		                  +"@foreach($cursos as $curso)"
		                      +"<option value='{{ $curso->codigo }}'>{{ $curso->nome }}</option>"
		                  +"@endforeach"
		    	+'</select>';
		html += '</div>';

		$('#auth-rows').append(html);

		document.getElementById("add").style.display = "none";
		document.getElementById("gerar").style.display = "block";
	    
	}

	function paises_dynamic_field()
	{
		html = '<div class="dropdown">';
		html += '<label>País</label><select name="dados" class="form-control custom-select" required>'
						  +"<option selected value='0'>Todos</option>"
		                  +"@foreach($paises as $pais)"
		                      +"<option value='{{ $pais->pais_id }}'>{{ $pais->pais_nome }}</option>"
		                  +"@endforeach"
		    	+'</select>';
		html += '</div>';

		$('#auth-rows').append(html);

		document.getElementById("add").style.display = "none";
		document.getElementById("gerar").style.display = "block";
	    
	}

	$(document).on('click', '#add', function(){
		if(	document.getElementById("tipo").value == 1){
			cursos_dynamic_field();
		}
		else{
			paises_dynamic_field();
		}
	});
});

</script>

<script type="text/javascript">
	$(function() {
	  /* ChartJS
	   * -------
	   * Data and config for chartjs
	   */
	  'use strict';
	  var paises = {
	    labels: [
	    		@foreach ($candidaturasPais->keys() as $key)
	      		[ "{{ $key }}", ],
	      	@endforeach
	    	],
	    datasets: [{
	      label: '# Intercambistas',
	      data: [
	      	@foreach ($candidaturasPais as $pais)
	      		[ "{{ count($pais) }}", ],
	      	@endforeach
	      ],
	      backgroundColor: [
	        'rgba(255, 99, 132, 0.2)',
	        'rgba(54, 162, 235, 0.2)',
	        'rgba(255, 206, 86, 0.2)',
	        'rgba(75, 192, 192, 0.2)',
	        'rgba(153, 102, 255, 0.2)',
	        'rgba(255, 159, 64, 0.2)'
	      ],
	      borderColor: [
	        'rgba(255,99,132,1)',
	        'rgba(54, 162, 235, 1)',
	        'rgba(255, 206, 86, 1)',
	        'rgba(75, 192, 192, 1)',
	        'rgba(153, 102, 255, 1)',
	        'rgba(255, 159, 64, 1)'
	      ],
	      borderWidth: 1,
	      fill: false
	    }]
	  };
	  var multiLineData = {
	    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
	    datasets: [{
	        label: 'Dataset 1',
	        data: [12, 19, 3, 5, 2, 3],
	        borderColor: [
	          '#587ce4'
	        ],
	        borderWidth: 2,
	        fill: false
	      },
	      {
	        label: 'Dataset 2',
	        data: [5, 23, 7, 12, 42, 23],
	        borderColor: [
	          '#ede190'
	        ],
	        borderWidth: 2,
	        fill: false
	      },
	      {
	        label: 'Dataset 3',
	        data: [15, 10, 21, 32, 12, 33],
	        borderColor: [
	          '#f44252'
	        ],
	        borderWidth: 2,
	        fill: false
	      }
	    ]
	  };
	  var options = {
	    scales: {
	      yAxes: [{
	        ticks: {
	          beginAtZero: true
	        }
	      }]
	    },
	    legend: {
	      display: false
	    },
	    elements: {
	      point: {
	        radius: 0
	      }
	    }

	  };
	  var cursos = {
	    datasets: [{
	      data: [
	      	@foreach ($candidaturasCurso as $curso)
	      		[ "{{ count($curso) }}", ],
	      	@endforeach
	      ],
	      backgroundColor: [
	        'rgba(255, 99, 132, 0.5)',
	        'rgba(54, 162, 235, 0.5)',
	        'rgba(255, 206, 86, 0.5)',
	        'rgba(75, 192, 192, 0.5)',
	        'rgba(153, 102, 255, 0.5)',
	        'rgba(255, 159, 64, 0.5)'
	      ],
	      borderColor: [
	        'rgba(255,99,132,1)',
	        'rgba(54, 162, 235, 1)',
	        'rgba(255, 206, 86, 1)',
	        'rgba(75, 192, 192, 1)',
	        'rgba(153, 102, 255, 1)',
	        'rgba(255, 159, 64, 1)'
	      ],
	    }],

	    // These labels appear in the legend and in the tooltips when hovering different arcs
	    labels: [
	    	@foreach ($candidaturasCurso->keys() as $key)
	      		[ "{{ $key }}", ],
	      	@endforeach
	    ]
	  };
	  var doughnutPieOptions = {
	    responsive: true,
	    animation: {
	      animateScale: true,
	      animateRotate: true
	    }
	  };
	  var anos = {
	    labels: [
	    		@foreach ($candidaturasAno->keys() as $key)
	      			[ "{{ $key }}", ],
	      		@endforeach
	    	],
	    datasets: [{
	      label: '# Intercambistas',
	      data: [
	      			@foreach ($candidaturasAno as $ano)
			      		[ "{{ count($ano) }}", ],
			      	@endforeach
	      		],
	      backgroundColor: [
	        // 'rgba(255, 99, 132, 0.2)',
	        // 'rgba(54, 162, 235, 0.2)',
	        // 'rgba(255, 206, 86, 0.2)',
	        // 'rgba(75, 192, 192, 0.2)',
	        // 'rgba(153, 102, 255, 0.2)',
	        // 'rgba(255, 159, 64, 0.2)'
	      ],
	      borderColor: [
	        // 'rgba(255,99,132,1)',
	        // 'rgba(54, 162, 235, 1)',
	        // 'rgba(255, 206, 86, 1)',
	        // 'rgba(75, 192, 192, 1)',
	        // 'rgba(153, 102, 255, 1)',
	        // 'rgba(255, 159, 64, 1)'
	      ],
	      borderWidth: 1,
	      fill: true, // 3: no fill
	    }]
	  };

	  var programas = {
	    labels: [
	    		@foreach ($candidaturasEdital->keys() as $key )
	      			[ "{{ $key }}", ],
	      		@endforeach
	    	],
	    datasets: [{
	      label: '# Intercambistas',
	      data: [
	      			@foreach ($candidaturasEdital as $edital)
			      		[ "{{ count($edital) }}", ],
			      	@endforeach
	      		],
	      backgroundColor: [
	        'rgba(255, 99, 132, 0.2)',
	        'rgba(54, 162, 235, 0.2)',
	        'rgba(255, 206, 86, 0.2)',
	        'rgba(75, 192, 192, 0.2)',
	        'rgba(153, 102, 255, 0.2)',
	        'rgba(255, 159, 64, 0.2)'
	      ],
	      borderColor: [
	        'rgba(255,99,132,1)',
	        'rgba(54, 162, 235, 1)',
	        'rgba(255, 206, 86, 1)',
	        'rgba(75, 192, 192, 1)',
	        'rgba(153, 102, 255, 1)',
	        'rgba(255, 159, 64, 1)'
	      ],
	      borderWidth: 1,
	      fill: true, // 3: no fill
	    }]
	  };

	  var areaOptions = {
	    plugins: {
	      filler: {
	        propagate: true
	      }
	    }
	  }

	  var multiAreaData = {
	    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	    datasets: [{
	        label: 'Facebook',
	        data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
	        borderColor: ['rgba(255, 99, 132, 0.5)'],
	        backgroundColor: ['rgba(255, 99, 132, 0.5)'],
	        borderWidth: 1,
	        fill: true
	      },
	      {
	        label: 'Twitter',
	        data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
	        borderColor: ['rgba(54, 162, 235, 0.5)'],
	        backgroundColor: ['rgba(54, 162, 235, 0.5)'],
	        borderWidth: 1,
	        fill: true
	      },
	      {
	        label: 'Linkedin',
	        data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
	        borderColor: ['rgba(255, 206, 86, 0.5)'],
	        backgroundColor: ['rgba(255, 206, 86, 0.5)'],
	        borderWidth: 1,
	        fill: true
	      }
	    ]
	  };

	  var multiAreaOptions = {
	    plugins: {
	      filler: {
	        propagate: true
	      }
	    },
	    elements: {
	      point: {
	        radius: 0
	      }
	    },
	    scales: {
	      xAxes: [{
	        gridLines: {
	          display: false
	        }
	      }],
	      yAxes: [{
	        gridLines: {
	          display: false
	        }
	      }]
	    }
	  }

	  var scatterChartData = {
	    datasets: [{
	        label: 'First Dataset',
	        data: [{
	            x: -10,
	            y: 0
	          },
	          {
	            x: 0,
	            y: 3
	          },
	          {
	            x: -25,
	            y: 5
	          },
	          {
	            x: 40,
	            y: 5
	          }
	        ],
	        backgroundColor: [
	          'rgba(255, 99, 132, 0.2)'
	        ],
	        borderColor: [
	          'rgba(255,99,132,1)'
	        ],
	        borderWidth: 1
	      },
	      {
	        label: 'Second Dataset',
	        data: [{
	            x: 10,
	            y: 5
	          },
	          {
	            x: 20,
	            y: -30
	          },
	          {
	            x: -25,
	            y: 15
	          },
	          {
	            x: -10,
	            y: 5
	          }
	        ],
	        backgroundColor: [
	          'rgba(54, 162, 235, 0.2)',
	        ],
	        borderColor: [
	          'rgba(54, 162, 235, 1)',
	        ],
	        borderWidth: 1
	      }
	    ]
	  }

	  var scatterChartOptions = {
	    scales: {
	      xAxes: [{
	        type: 'linear',
	        position: 'bottom'
	      }]
	    }
	  }
	  // Get context with jQuery - using jQuery's .get() method.
	  if ($("#barChart").length) {
	    var barChartCanvas = $("#barChart").get(0).getContext("2d");
	    // This will get the first returned node in the jQuery collection.
	    var barChart = new Chart(barChartCanvas, {
	      type: 'bar',
	      data: paises,
	      options: options
	    });
	  }

	  if ($("#lineChart").length) {
	    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
	    var lineChart = new Chart(lineChartCanvas, {
	      type: 'bar',
	      data: anos,
	      options: options
	    });
	  }

	  if ($("#linechart-multi").length) {
	    var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
	    var lineChart = new Chart(multiLineCanvas, {
	      type: 'line',
	      data: multiLineData,
	      options: options
	    });
	  }

	  if ($("#areachart-multi").length) {
	    var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
	    var multiAreaChart = new Chart(multiAreaCanvas, {
	      type: 'line',
	      data: multiAreaData,
	      options: multiAreaOptions
	    });
	  }

	  if ($("#doughnutChart").length) {
	    var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
	    var doughnutChart = new Chart(doughnutChartCanvas, {
	      type: 'doughnut',
	      data: doughnutPieData,
	      options: doughnutPieOptions
	    });
	  }

	  if ($("#pieChart").length) {
	    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
	    var pieChart = new Chart(pieChartCanvas, {
	      type: 'pie',
	      data: cursos,
	      options: doughnutPieOptions
	    });
	  }

	  if ($("#areaChart").length) {
	    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
	    var areaChart = new Chart(areaChartCanvas, {
	      type: 'doughnut',
	      data: programas,
	      options: doughnutPieOptions
	    });
	  }

	  if ($("#scatterChart").length) {
	    var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
	    var scatterChart = new Chart(scatterChartCanvas, {
	      type: 'scatter',
	      data: scatterChartData,
	      options: scatterChartOptions
	    });
	  }

	  if ($("#browserTrafficChart").length) {
	    var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
	    var doughnutChart = new Chart(doughnutChartCanvas, {
	      type: 'doughnut',
	      data: browserTrafficData,
	      options: doughnutPieOptions
	    });
	  }
	});
</script>


@endsection
