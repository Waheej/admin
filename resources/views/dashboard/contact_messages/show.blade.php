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
                            <label for="exampleInputName">{{ trans('cruds.' . $path . '.' . 'name') }}</label>
                            <input type="text" class="form-control" id="exampleInputName"
                                value="{{ $record->name ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMobile">{{ trans('cruds.' . $path . '.' . 'mobile') }}</label>
                            <input type="text" class="form-control" id="exampleInputMobile"
                                value="{{ $record->mobile . ' ' . $record->mobile ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">{{ trans('cruds.' . $path . '.' . 'email') }}</label>
                            <input type="text" class="form-control" id="exampleInputEmail"
                                value="{{ $record->email ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMessage">{{ trans('cruds.' . $path . '.' . 'message') }}</label>
                            <textarea class="form-control" id="exampleInputMessage" rows="4" disabled>{{ $record->message ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputStatus">{{ trans('cruds.' . $path . '.' . 'status') }}</label>
                            <input type="text" class="form-control" id="exampleInputStatus"
                                value="{{ isset(\App\Enums\GeneralEnums::ContactMessageStatuses[app()->getLocale()][$record->status]) ? \App\Enums\GeneralEnums::ContactMessageStatuses[app()->getLocale()][$record->status] : '' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputProjectId">{{ trans('cruds.' . $path . '.' . 'project_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputProjectId"
                                value="{{ $record->project ? $record->project->{'name_' . app()->getLocale()} : '' }}"
                                disabled>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
