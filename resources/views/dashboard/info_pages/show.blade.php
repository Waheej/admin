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
                            <label for="exampleInputTitleEn">{{ trans('cruds.' . $path . '.' . 'title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleEn"
                                value="{{ $record->title_en ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitleAr">{{ trans('cruds.' . $path . '.' . 'title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleAr"
                                value="{{ $record->title_ar ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="description_en">
                                {{ trans('cruds.' . $path . '.' . 'description_en') }}
                            </label>
                            <div class="form-control" id="description_en" style="min-height: 150px; overflow-y: auto;">
                                {!! $record->description_en ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('description_en'))
                                <span class="text-danger">{{ $errors->first('description_en') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description_ar">
                                {{ trans('cruds.' . $path . '.' . 'description_ar') }}
                            </label>
                            <div class="form-control" id="description_ar" style="min-height: 150px; overflow-y: auto;">
                                {!! $record->description_ar ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('description_ar'))
                                <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputType">{{ trans('cruds.' . $path . '.' . 'type') }}</label>
                            <input type="text" class="form-control" id="exampleInputType"
                                value="{{ \App\Enums\GeneralEnums::InfoPageTypes[app()->getLocale()][$record->type] ?? '' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOrder">{{ trans('cruds.' . $path . '.' . 'order') }}</label>
                            <input type="text" class="form-control" id="exampleInputOrder"
                                value="{{ $record->order ?? '' }}" disabled>
                        </div>

                        <!-- Media Path Display -->
                        <div class="form-group">
                            <label for="mediaPath">{{ trans('cruds.' . $path . '.' . 'media_path') }}</label>
                            <div>
                                @php
                                    $fileExtension = pathinfo($record->media_path, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $record->media_path }}" alt="Media Image"
                                        style="max-width: 300px; height: auto;">
                                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                                    <video width="320" height="240" controls>
                                        <source src="{{ $record->media_path }}"
                                            type="video/{{ $fileExtension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <p>{{ trans('cruds.' . $path . '.file_not_supported') }}</p>
                                @endif
                            </div>
                        </div>

                        <label>{{ trans('cruds.' . $path . '.is_active') }}</label>
                        <div class="form-group">
                            <label class="switch">
                                <input type="checkbox" class="form-control" id="exampleInputIsActive"
                                    {{ $record->is_active == true ? 'checked' : '' }} disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCreatedAt">{{ trans('cruds.' . $path . '.' . 'created_at') }}</label>
                            <input type="text" class="form-control" id="exampleInputCreatedAt"
                                value="{{ \Carbon\Carbon::parse($record->created_at)->diffForHumans() ?? '' }}" disabled>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
