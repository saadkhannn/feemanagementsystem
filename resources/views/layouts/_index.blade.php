@php
  $systemInformation = session()->get('system-information');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $systemInformation->name }}</title>
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/css/datatables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lte/jquery-confirm/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lte/wnoty/wnoty.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/css/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/jsTree/themes/default/style.min.css') }}"/>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="icon" href="{{ url('system-images/icons/'.$systemInformation->icon) }}" type="image/png">

    @include('layouts.css')
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper" style="zoom: 80%">
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ol class="breadcrumb float-sm-right" style="margin-bottom: 0px;background: white;">
      <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
      @include('layouts.where')
    </ol>
    @php
      $employee = \Modules\Peoples\Entities\Employee::with([
        'details'
      ])->findOrFail(auth()->user()->employee_id);
    @endphp
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ employeeImage($employee) }}" width="40" height="40" class="rounded-circle" style="margin-top: -10px">
        </a>
        <div class="dropdown-menu" style="margin-left: -100px;margin-top: 5px;" aria-labelledby="navbarDropdownMenuLink">
          <a href="{{ url('peoples/employees/'.$employee->id) }}" class="dropdown-item">
            <i class="fa fa-user nav-icon"></i>&nbsp;My Profile
          </a>
          <a href="{{ url('peoples/employees/'.$employee->id.'/image-upload') }}" class="dropdown-item">
            <i class="fa fa-upload nav-icon"></i>&nbsp;My Image
          </a>
          <a href="{{ url('peoples/change-password') }}" class="dropdown-item">
            <i class="fa fa-user nav-icon"></i>&nbsp;Change Password
          </a>
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
            <i class="fa fa-sign-out-alt nav-icon"></i>&nbsp;Log Out
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </a>
        </div>
      </li>   
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    {!! getSidebar() !!}
  </aside>

  <div class="content-wrapper">
    <section class="content" style="padding-top: 25px">
      <div class="container-fluid one-pager-loading" style="display: none">
        <div class="row">
          <div class="col-md-12 mt-5 pt-5 text-center">
            <img src="{{ asset('lte/loading.gif') }}" />
          </div>
        </div>
      </div>

      <div class="container-fluid one-pager-content">
        {{-- @yield('content') --}}
      </div>
      @include('tools.modals')
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ $systemInformation->name }}</a></strong>
    &nbsp;
    All rights reserved.
  </footer>
</div>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('lte/dist/js/demo.js') }}"></script>
<script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('lte/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('lte/wnoty/wnoty.js') }}"></script>
<script src="{{ asset('lte/jsTree/jstree.min.js') }}"></script>
<script src="{{ asset('cdn/js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('cdn/js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('cdn/js/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('cdn/js/datatable/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('lte/bootstrap-datetimepicker/moment.min.js') }}" ></script>
<script src="{{ asset('lte/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('cdn/js/summernote.min.js') }}"></script>

<script type="text/javascript">
  var base_url = "{{ url('/') }}";

  $(document).ready(function() {
    $.each($('.one-pager'), function(index, val) {
      var link = $(this);
      $(this).click(function(event) {
        event.preventDefault();
        
        if(link.attr('data-href') != undefined && link.attr('data-href') != '#'){
          window.history.pushState({path:link.attr('data-href')},'',link.attr('data-href'));
          $('.one-pager-loading').show();
          $('.one-pager-content').html('');
          $.ajax({
            url: link.attr('data-href'),
            type: 'GET',
            data: {},
          })
          .done(function(response) {
            $('.one-pager-loading').hide();
            $('.one-pager-content').html(response);
          });
        }
      });
    });
  });
</script>

@include('layouts.js')
</body>
</html>
