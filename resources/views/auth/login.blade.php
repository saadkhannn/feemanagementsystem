@php
  $systemInformation = session()->get('system-information');
@endphp
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $systemInformation->name }} | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('lte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte') }}/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="icon" href="{{ url('system-images/icons/'.$systemInformation->icon) }}" type="image/png">
  <style type="text/css">
    body {
        height: 100vh;
        background: linear-gradient(to top, #c9c9ff 50%, #9090fa 90%) no-repeat !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width: 420px !important;">
  <div class="card">
    <div class="card-body login-card-body">
        <div class="row">
            <div class="col-md-12 mb-2 text-center">
                <img src="{{ url('system-images/logos/'.$systemInformation->logo) }}" style="max-height: 100px">
            </div>
            <div class="col-md-12 text-center">
                <p class="login-box-msg">
                  {{ $systemInformation->motto }}
                  <br>
                  {{ $systemInformation->tagline }}
                </p>
            </div>
            <div class="col-md-12">
                <form action="{{ route('login') }}" method="post">
                @csrf
                    <div class="input-group mb-3">
                      <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                    <div class="input-group mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                        <div class="icheck-primary">
                          <input type="checkbox" id="remember">
                          <label for="remember">
                            Remember Me
                          </label>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                      </div>
                      <!-- /.col -->
                    </div>
                </form>
            </div>
            @if($errors->any())
            <div class="col-md-12 mt-3">
                <ul class="pl-3 text-danger">
                    @foreach($errors->all() as $key => $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

      {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}

    </div>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte') }}/dist/js/adminlte.min.js"></script>

</body>
</html>