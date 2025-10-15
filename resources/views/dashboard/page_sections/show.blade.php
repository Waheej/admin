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
                                value="{{ \App\Enums\GeneralEnums::HomePageSectionTypes[app()->getLocale()][$record->type] ?? '' }}"
                                disabled>
                        </div>
                        {{-- <div class="form-group">
                            @php $name = "title_".app()->getLocale(); @endphp
                            <label for="exampleInputPageTypeId">{{ trans('cruds.' . $path . '.page_type_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputpageType"
                                value="{{ $record->pageType?->$name }}" disabled>
                        </div> --}}
                        <div class="form-group">
                            <label for="exampleInputOrder">{{ trans('cruds.' . $path . '.' . 'order') }}</label>
                            <input type="text" class="form-control" id="exampleInputOrder"
                                value="{{ $record->order ?? '' }}" disabled>
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
                        <div class="form-group">
                            @php $name = "name_".app()->getLocale(); @endphp
                            <label for="exampleInputProjectId">{{ trans('cruds.' . $path . '.project_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputproject"
                                value="{{ $record->project?->$name }}" disabled>
                        </div>

                        {{-- additional_data --}}
                        @if ($record->additional_data)
                            @php
                                // Decode JSON if it's stored as string
                                $additionalData = is_string($record->additional_data)
                                    ? json_decode($record->additional_data, true)
                                    : $record->additional_data;
                            @endphp

                            <div class="form-group">
                                <label for="additional_data">{{ trans('cruds.' . $path . '.additional_data') }}</label>

                                @if (!empty($additionalData) && is_array($additionalData))
                                    <table class="table table-bordered" id="additional_data">
                                        <thead>
                                            <tr>
                                                <th>Label En</th>
                                                <th>Label Ar</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($additionalData as $key => $value)
                                                <tr>
                                                    <td>{{ $value['label_en'] ?? $key }}</td>
                                                    <td>{{ $value['label_ar'] ?? $key }}</td>
                                                    <td>{{ $value['value'] ?? (is_array($value) ? json_encode($value) : $value) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="form-control" id="additional_data"
                                        style="min-height: 150px; overflow-y: auto;">
                                        <pre>{{ json_encode($record->additional_data, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                @endif
                            </div>
                        @endif
                        {{-- Media --}}
                        <div class="form-group">
                            <div>
                                @if ($record->media)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'media') }} :</strong></p>
                                    @foreach ($record->media as $image)
                                        <img src="{{ $image }}" alt="Cover Image"
                                            style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                    @endforeach
                                @endif

                                @if ($record->mobile_media)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'mobile_media') }} :</strong></p>
                                    @foreach ($record->mobile_media as $image)
                                        <img src="{{ $image }}" alt="Cover Image"
                                            style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                    @endforeach
                                @endif

                                @if ($record->videos)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'videos') }} :</strong></p>
                                    @foreach ($record->videos as $video)
                                        <video controls style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                            <source src="{{ $video }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
