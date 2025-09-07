<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AqarPedia | Log in</title>
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
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <h1>{{ trans('global.site_title') }}</h1>

                    <p class="text-muted">{{ trans('global.reset_password') }}</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- <form method="POST" action="{{ route('password.email') }}"> --}}
                    {{-- TODO: we need integrate with email service provider and make reset password email template --}}
                    <form method="POST" action="#">

                        @csrf

                        <div class="form-group">
                            <input id="email" type="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                                value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn button-purple btn-flat btn-block">
                                    {{ trans('global.send_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
