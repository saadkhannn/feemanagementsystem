@php
    $systemInformation = session()->get('system-information');
	$currenturl = url()->current();
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Panel | {{isset($title) ? $title :''}}</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="icon" href="{{ url('system-images/icons/'.$systemInformation->icon) }}" type="image/png">

    @if(!$currenturl)
        <link rel="stylesheet" href="{{ asset('cdn/css/bootstrap.css') }}">
    @endif
    <link rel="stylesheet" href="{{asset('frontend/css/core.min.css')}}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frontend') }}/jquery-toast-plugin/jquery.toast.min.css">
    @yield('custom-css')
</head>
<body>

@yield('main-body')
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('frontend') }}/jquery-toast-plugin/jquery.toast.min.js"></script>

@yield('custom-js')
<script !src="">
    !(function (c) {
        "use strict";

        function t() {
        }

        (t.prototype.send = function (t, o, i, e, n, a, s, r) {
            t = {
                heading: t,
                text: o,
                position: i,
                loaderBg: e,
                icon: n,
                hideAfter: (a = a || 3e3),
                stack: (s = s || 1)
            };
            (t.showHideTransition = r || "fade"), c.toast().reset("all"), c.toast(t);
        }),
            (c.NotificationApp = new t()),
            (c.NotificationApp.Constructor = t),

            @if (Session::has('message'))
            c.NotificationApp.send("{{ ucfirst(Session::get('alert-type')) }}", "{{ Session::get('message') }}",
                "top-right", "rgba(0,0,0,0.2)", "{{ Session::get('alert-type') }}");
        @elseif (count($errors) > 0)
        @foreach ($errors->all() as $error)
        c.NotificationApp.send("Error", "{{ $error }}", "top-right", "rgba(0,0,0,0.2)", "error");
        @endforeach
        @endif

        $(".select2-tags").select2({
            tags: true
        });

        $(".select2").select2();

    })(window.jQuery);
</script>
</body>
</html>
