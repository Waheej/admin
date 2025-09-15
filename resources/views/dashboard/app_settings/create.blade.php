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
                <form role="form" method="POST" action="{{ route('admin.app_settings.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputKey">{{ trans('cruds.' . $path . '.' . 'key') }}</label>
                            <input type="text" class="form-control" id="exampleInputKey" name="{{ 'key' }}"
                                value="{{ old('key') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'key') }}">
                            @if ($errors->has('key'))
                                <span class="text-danger">{{ $errors->first('key') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitleEn">{{ trans('cruds.' . $path . '.' . 'title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleEn" name="{{ 'title_en' }}"
                                value="{{ old('title_en') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'title_en') }}">
                            @if ($errors->has('title_en'))
                                <span class="text-danger">{{ $errors->first('title_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitleAr">{{ trans('cruds.' . $path . '.' . 'title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleAr" name="{{ 'title_ar' }}"
                                value="{{ old('title_ar') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'title_ar') }}">
                            @if ($errors->has('title_ar'))
                                <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputValue">{{ trans('cruds.' . $path . '.' . 'value') }}</label>
                            <textarea class="form-control" id="exampleInputValue" name="value"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'value') }}">{{ old('value') }}</textarea>
                            @if ($errors->has('value'))
                                <span class="text-danger">{{ $errors->first('value') }}</span>
                            @endif
                        </div>

                        <div>
                            <button class="btn  button-purple btn-lg" type="submit">
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
