<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mobilidade Out</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../theme/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../../theme/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../theme/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../theme/images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/home"><img src="../../../theme/images/aeri-logo-black.png" class="brand-logo" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/home"><img src="../../../theme/images/aeri-logo-black.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <div class="mr-lg-6">
              <span class="menu-title">{{ Auth::user()->name }}</span>
            </div>   
          </li>
            @if(isset(Auth::user()->unreadNotifications[0] ))
              <li class="nav-item dropdown">
                  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="ti-bell mx-0"></i>
                    <span class="count"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown" style="height:300px; overflow:scroll;">
                    <div class="row">
                      <div class="col-sm-8">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notificações</p>
                      </div>
                      <div class="col-sm-4">
                        <a title="Marcar todas como lida" href="/markasread">
                          <i class="ti-check"></i>
                        </a>
                      </div>
                    </div>
                    @foreach (Auth::user()->unreadNotifications as $notification)
                      <a class="dropdown-item" href="{{ route('notification', $notification->id) }}">
                        <div class="item-thumbnail">
                          <div class="item-icon {{ $notification->data['bg'] }}">
                            <i class="{{ $notification->data['icon'] }} mx-0"></i>
                          </div>
                        </div>
                        <div class="item-content">
                          <h6 class="font-weight-normal">{{ $notification->data['message'] }}</h6>
                          <p class="font-weight-light small-text mb-0 text-muted">
                            {{ $notification->created_at->format('d/m/Y') }}
                          </p>
                        </div>
                      </a>
                    @endforeach
                </div>
              </li>
            @else
            <li class="nav-item dropdown">
                  <a class="nav-link  " id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="ti-bell"></i>
                    <span class="count"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown" style="height:300px; overflow:scroll;">
                    <div class="row">
                      <div class="col-sm-8">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notificações</p>
                      </div>
                      <div class="col-sm-4">
                        <a title="Marcar todas como lida" href="/markasread">
                          <i class="ti-check"></i>
                        </a>
                      </div>
                    </div>
                    <a class="dropdown-item" href="/editais/detalhes/1">
                      <div class="item-content">
                        <h6 class="font-weight-normal">Não existe notificações no momento</h6>
                      </div>
                    </a>
                  </div>
              </li>
            @endif
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="ti-user menu-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a href="/configuracoes" class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Configurações
              </a>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="ti-power-off text-primary"></i>
                Sair
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/home">
              <i class="ti-home menu-icon"></i>
              <span class="menu-title">Home</span>
            </a>
          </li>
          @if(Auth::user()->privilegio == 4)
          <li class="nav-item">
            <a class="nav-link" href="/equipe">
             <i class="ti-user menu-icon"></i>
              <span class="menu-title">Equipe</span>
            </a>
          </li>
          @endif
          @if(Auth::user()->privilegio == 2 || Auth::user()->privilegio == 4)
          <li class="nav-item">
            <a class="nav-link" href="/editais">
              <i class="ti-write menu-icon"></i>
              <span class="menu-title">Editais</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/recursos">
             <i class="ti-comments menu-icon"></i>
              <span class="menu-title">Recursos</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/convenios">
             <i class="ti-world menu-icon"></i>
              <span class="menu-title">Convênios</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/relatorios/in">
             <i class="ti-bar-chart-alt menu-icon"></i>
              <span class="menu-title">Relatórios In</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/relatorios/out">
             <i class="ti-bar-chart menu-icon"></i>
              <span class="menu-title">Relatórios Out</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/programas">
             <i class="ti-gallery menu-icon"></i>
              <span class="menu-title">Programas</span>
            </a>
          </li>
          @endif
          @if(Auth::user()->privilegio == 1)
          <li class="nav-item">
            <a class="nav-link" href="/candidato">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">Meus Dados</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/candidaturas">
              <i class="ti-layout-list-post menu-icon"></i>
              <span class="menu-title">Minhas Inscrições</span>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Begin Main Content -->

          @yield('content')

          <!-- End Main Content -->
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center align-self-center d-block d-sm-inline-block">© 2021 - Mobilidade Out - AERI - Todos os direitos reservados.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Feito com <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->


  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione "Sair" se você desejar sair da sessão.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
              Sair
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- plugins:js -->
  <script src="../../../theme/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../../../theme/vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../../theme/js/off-canvas.js"></script>
  <script src="../../../theme/js/hoverable-collapse.js"></script>
  <script src="../../../theme/js/template.js"></script>
  <script src="../../../theme/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../theme/js/dashboard.js"></script>
  <script src="../../../js/submit.js"></script>

  @yield('scripts')

  <!-- End custom js for this page-->
</body>

</html>

