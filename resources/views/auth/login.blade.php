<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('global.site_title') }} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/public/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        .button-purple {
            background-color: {{ PRIMARY_COLOR_HEX }};
            color: #fff;
        }

        a {
            color: {{ PRIMARY_COLOR_HEX }};
        }

        .icheck-primary>input:first-child:checked+input[type=hidden]+label::before,
        .icheck-primary>input:first-child:checked+label::before {
            background-color: {{ PRIMARY_COLOR_HEX }};
            border-color: {{ PRIMARY_COLOR_HEX }};
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="">{{ trans('global.site_title') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ trans('global.login') }}</p>
                @if (session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" name="email" type="text"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                            autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                            value="{{ old('email', null) }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" name="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                            placeholder="{{ trans('global.login_password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                    style="vertical-align: middle;" />
                                <label for="remember">
                                    {{ trans('global.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn button-purple btn-block btn-sm">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
