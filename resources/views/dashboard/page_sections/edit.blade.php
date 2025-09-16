@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ trans('cruds.' . $path . '.title_plural') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a style="color:{{ PRIMARY_COLOR_HEX }};"
                                    href="{{ route('admin.home') }}">{{ trans('cruds.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ trans('cruds.' . $path . '.title_singular') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="{{ 'card card-' . PRIMARY_COLOR }}">
                <div class="card-header">
                    <h3 style="font-size: 1.1rem;font-weight: 400;">{{ trans('cruds.' . $path . '.title_singular') }}</h3>
                </div>

                <form role="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.page_sections.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputTitleEn">{{ trans('cruds.' . $path . '.' . 'title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleEn" name="{{ 'title_en' }}"
                                value="{{ old('title_en', $record->title_en) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'title_en') }}">
                            @if ($errors->has('title_en'))
                                <span class="text-danger">{{ $errors->first('title_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitleAr">{{ trans('cruds.' . $path . '.' . 'title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTitleAr" name="{{ 'title_ar' }}"
                                value="{{ old('title_ar', $record->title_ar) }}"
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
                                    {{ old('description_en', $record->description_en) }}
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
                                    {{ old('description_ar', $record->description_ar) }}
                                </textarea>

                            @if ($errors->has('description_ar'))
                                <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOrder">{{ trans('cruds.' . $path . '.' . 'order') }}</label>
                            <input type="number" class="form-control" id="exampleInputOrder" name="{{ 'order' }}"
                                value="{{ old('order', $record->order) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'order') }}">
                            @if ($errors->has('order'))
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputType">{{ trans('cruds.' . $path . '.' . 'type') }}</label>
                            <select class="form-control" id="exampleInputType" name="type">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.type')]) }}
                                </option>
                                @php $types = \App\Enums\GeneralEnums::HomePageSectionTypes[app()->getLocale()]; @endphp
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('type', $record->type) == $key ? 'selected' : '' }}>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>

                         <div class="form-group">
                            <label for="media">{{ trans('cruds.' . $path . '.' . 'media') }}</label>
                            <input type="file" class="form-control-file" id="media" name="media[]"
                                multiple>
                            @if ($record->media)
                                <p>Current Images:</p>
                                @foreach ($record->media as $image)
                                    <img src="{{ $image }}" style="max-width: 100px; margin-right: 10px;">
                                    <a href="{{ route('admin.page_sections.delete_image', ['id' => $record->id, 'file_name' => $image, 'label' => 'media']) }}"
                                        class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @endforeach
                            @endif
                            @if ($errors->has('media'))
                                <span class="text-danger">{{ $errors->first('media') }}</span>
                            @endif
                        </div>

                        <div>
                            <button class="btn button-purple btn-lg" type="submit">{{ trans('global.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
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
