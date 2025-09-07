@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ trans('cruds.' . $path . '.title_plural') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a style="color:{{ PRIMARY_COLOR_HEX }};"
                                    href="{{ route('admin.home') }}">{{ trans('cruds.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ trans('cruds.' . $path . '.title_plural') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="{{ 'card card-' . PRIMARY_COLOR }}">
                <div class="card-header">
                    <h3 style="font-size: 1.1rem;font-weight: 400;">{{ trans('cruds.' . $path . '.title_singular') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="POST" action="{{ route('admin.admins.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFullName">{{ trans('cruds.' . $path . '.full_name') }}</label>
                            <input type="text" class="form-control" id="exampleInputFullName" name="full_name"
                                value="{{ old('full_name') }}" placeholder="{{ trans('cruds.' . $path . '.full_name') }}">
                            @if ($errors->has('full_name'))
                                <span class="text-danger">{{ $errors->first('full_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">{{ trans('cruds.' . $path . '.email') }}</label>
                            <input type="email" class="form-control" id="exampleInputEmail" name="email"
                                value="{{ old('email') }}" placeholder="{{ trans('cruds.' . $path . '.email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCountryCode">{{ trans('cruds.' . $path . '.country_code') }}</label>
                            <input type="text" class="form-control" id="exampleInputCountryCode" name="country_code"
                                value="{{ old('country_code') }}"
                                placeholder="{{ trans('cruds.' . $path . '.country_code') }}">
                            @if ($errors->has('country_code'))
                                <span class="text-danger">{{ $errors->first('country_code') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMobile">{{ trans('cruds.' . $path . '.mobile') }}</label>
                            <input type="text" class="form-control" id="exampleInputMobile" name="mobile"
                                value="{{ old('mobile') }}" placeholder="{{ trans('cruds.' . $path . '.mobile') }}">
                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">{{ trans('cruds.' . $path . '.password') }}</label>
                            <input type="password" class="form-control" id="exampleInputPassword" name="password"
                                placeholder="{{ trans('cruds.' . $path . '.password') }}">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputPasswordConfirmation">{{ trans('cruds.' . $path . '.password_confirmation') }}</label>
                            <input type="password" class="form-control" id="exampleInputPasswordConfirmation"
                                name="password_confirmation"
                                placeholder="{{ trans('cruds.' . $path . '.password_confirmation') }}">
                        </div>
                        <div class="form-group">
                            @php $title = "title_" . app()->getLocale(); @endphp
                            <label for="exampleInputRole">{{ trans('cruds.' . $path . '.role_id') }}</label>
                            <select class="form-control" id="exampleInputRole" name="role_id">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.role_id')]) }}
                                </option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->$title }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            @endif
                        </div>
                        <div>
                            <button class="btn button-purple btn-lg" type="submit">
                                {{ trans('global.create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
