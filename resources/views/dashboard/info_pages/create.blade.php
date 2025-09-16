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
                <form role="form" method="POST" action="{{ route('admin.info_pages.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputTitleEn">{{ trans('cruds.' . $path . '.' . 'title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleEn" name="title_en"
                                value="{{ old('title_en') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'title_en') }}">
                            @if ($errors->has('title_en'))
                                <span class="text-danger">{{ $errors->first('title_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitleAr">{{ trans('cruds.' . $path . '.' . 'title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleAr" name="title_ar"
                                value="{{ old('title_ar') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'title_ar') }}">
                            @if ($errors->has('title_ar'))
                                <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description_en">
                                {{ trans('cruds.' . $path . '.' . 'description_en') }}
                            </label>
                            <textarea class="form-control" id="description_en" name="description_en"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'description_en') }}">
                                {{ old('description_en') }}
                            </textarea>

                            @if ($errors->has('description_en'))
                                <span class="text-danger">{{ $errors->first('description_en') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description_ar">
                                {{ trans('cruds.' . $path . '.' . 'description_ar') }}
                            </label>
                            <textarea class="form-control" id="description_ar" name="description_ar"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'description_ar') }}">
                                {{ old('description_ar') }}
                            </textarea>

                            @if ($errors->has('description_ar'))
                                <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputType">{{ trans('cruds.' . $path . '.' . 'type') }}</label>
                            <select class="form-control" id="exampleInputType" name="type">
                                <option value="" disabled>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.type')]) }}
                                </option>
                                @php $types = \App\Enums\GeneralEnums::InfoPageTypes[app()->getLocale()]; @endphp
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputOrder">{{ trans('cruds.' . $path . '.' . 'order') }}</label>
                            <input type="number" class="form-control" id="exampleInputOrder" name="order"
                                value="{{ old('order') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'order') }}">
                            @if ($errors->has('order'))
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            @php $name = "name_" . app()->getLocale(); @endphp
                            <label for="exampleInputProjectId">{{ trans('cruds.' . $path . '.project_id') }}</label>
                            <select class="form-control" id="exampleInputProjectId" name="project_id">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.project_id')]) }}
                                </option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->$name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('project_id'))
                                <span class="text-danger">{{ $errors->first('project_id') }}</span>
                            @endif
                        </div>

                        <!-- Media Path Upload -->
                        <div class="form-group">
                            <label for="mediaPath">{{ trans('cruds.' . $path . '.' . 'media_path') }}</label>
                            <input type="file" class="form-control-file" id="mediaPath" name="media_path">
                            @if ($errors->has('media_path'))
                                <span class="text-danger">{{ $errors->first('media_path') }}</span>
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
    <script>
        ClassicEditor
            .create(document.querySelector('#description_en'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
        ClassicEditor
            .create(document.querySelector('#description_ar'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
@endsection
