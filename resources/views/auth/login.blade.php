<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mobilidade Aeri</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="theme/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="theme/vendors/base/vendor.bundle.base.class">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="theme/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="theme/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo text-center">
                <img src="theme/images/aeri-logo-black.png" alt="logo"> 
                <h4 class="text-center">MOBILIDADE OUT</h4>
                <h6 class="font-weight-light text-center">Bem vindo!</h6>
              </div>     
              <form class="form-horizontal form-prevent-multiple-submits" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email">Email</label>

                  <div class="input-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password">Senha</label>

                 <div class="input-group">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Me mantenha conectado
                    </label>
                  </div>
                  <a href="{{ url('/password/reset') }}" class="auth-link text-black">Esqueceu a senha?</a>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <button type="submit"  class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn button-prevent-multiple-submits">
                      Entrar
                    </button>

                    <div class="text-center mt-4 font-weight-light">
                      Nao possui uma conta? <a href="{{ route('register') }}" class="text-primary">Cadastre-se</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-black font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="theme/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="theme/js/off-canvas.js"></script>
  <script src="theme/js/hoverable-collapse.js"></script>
  <script src="theme/js/template.js"></script>
  <script src="theme/js/todolist.js"></script>
  <script src="js/submit.js"></script>
  <!-- endinject -->
</body>

</html>
