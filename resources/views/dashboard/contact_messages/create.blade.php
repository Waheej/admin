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
                <form role="form" method="POST" action="{{ route('admin.contact_messages.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputName">{{ trans('cruds.' . $path . '.' . 'name') }}</label>
                            <input type="text" class="form-control" id="exampleInputName" name="{{ 'name' }}"
                                value="{{ old('name') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputCountryCode">{{ trans('cruds.' . $path . '.' . 'country_code') }}</label>
                            <input type="text" class="form-control" id="exampleInputCountryCode"
                                name="{{ 'country_code' }}" value="{{ old('country_code') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'country_code') }}">
                            @if ($errors->has('country_code'))
                                <span class="text-danger">{{ $errors->first('country_code') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMobile">{{ trans('cruds.' . $path . '.' . 'mobile') }}</label>
                            <input type="text" class="form-control" id="exampleInputMobile" name="{{ 'mobile' }}"
                                value="{{ old('mobile') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'mobile') }}">
                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">{{ trans('cruds.' . $path . '.' . 'email') }}</label>
                            <input type="text" class="form-control" id="exampleInputEmail" name="{{ 'email' }}"
                                value="{{ old('email') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMessage">{{ trans('cruds.' . $path . '.' . 'message') }}</label>
                            <input type="text" class="form-control" id="exampleInputMessage" name="{{ 'message' }}"
                                value="{{ old('message') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'message') }}">
                            @if ($errors->has('message'))
                                <span class="text-danger">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputStatus">{{ trans('cruds.' . $path . '.' . 'status') }}</label>
                            <input type="text" class="form-control" id="exampleInputStatus" name="{{ 'status' }}"
                                value="{{ old('status') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'status') }}">
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCompoundId">{{ trans('cruds.' . $path . '.' . 'compound_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputCompoundId"
                                name="{{ 'compound_id' }}" value="{{ old('compound_id') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'compound_id') }}">
                            @if ($errors->has('compound_id'))
                                <span class="text-danger">{{ $errors->first('compound_id') }}</span>
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
    <script></script>
@endsection
