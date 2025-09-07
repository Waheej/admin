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
                    <h3 class="card-title">{{ trans('cruds.' . $path . '.title_singular') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputId">#</label>
                            <input type="number" class="form-control" id="exampleInputId" value="{{ $record->id ?? '' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFullName">{{ trans('cruds.' . $path . '.full_name') }}</label>
                            <input type="text" class="form-control" id="exampleInputFullName"
                                value="{{ $record->full_name ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">{{ trans('cruds.' . $path . '.email') }}</label>
                            <input type="text" class="form-control" id="exampleInputEmail"
                                value="{{ $record->email ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMobile">{{ trans('cruds.' . $path . '.mobile') }}</label>
                            <input type="text" class="form-control" id="exampleInputMobile"
                                value="{{ $record->country_code . $record->mobile ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputLocale">{{ trans('cruds.' . $path . '.locale') }}</label>
                            <input type="text" class="form-control" id="exampleInputLocale"
                                value="{{ $record->locale ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            @php $title = "title_".app()->getLocale(); @endphp
                            <label for="exampleInputRole">{{ trans('cruds.' . $path . '.role_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputRole"
                                value="{{ $record->role?->$title }}" disabled>
                        </div>
                        <label>{{ trans('cruds.' . $path . '.is_active') }}</label>
                        <div class="form-group">
                            <label class="switch">
                                <input type="checkbox" class="form-control" id="exampleInputIsActive"
                                    {{ $record->is_active == true ? 'checked' : '' }} disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
