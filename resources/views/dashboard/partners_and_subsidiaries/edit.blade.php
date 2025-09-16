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

                <form role="form" method="POST" enctype="multipart/form-data"
                    action="{{ route('admin.partners_and_subsidiaries.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputUrl">{{ trans('cruds.' . $path . '.' . 'url') }}</label>
                            <input type="text" class="form-control" id="exampleInputUrl" name="{{ 'url' }}"
                                value="{{ old('url', $record->url) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'url') }}">
                            @if ($errors->has('url'))
                                <span class="text-danger">{{ $errors->first('url') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNameEn">{{ trans('cruds.' . $path . '.' . 'name_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameEn" name="{{ 'name_en' }}"
                                value="{{ old('name_en', $record->name_en) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'name_en') }}">
                            @if ($errors->has('name_en'))
                                <span class="text-danger">{{ $errors->first('name_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNameAr">{{ trans('cruds.' . $path . '.' . 'name_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameAr" name="{{ 'name_ar' }}"
                                value="{{ old('name_ar', $record->name_ar) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'name_ar') }}">
                            @if ($errors->has('name_ar'))
                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
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
                            <label for="exampleInputType">{{ trans('cruds.' . $path . '.' . 'type') }}</label>
                            <select class="form-control" id="exampleInputType" name="type">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.type')]) }}
                                </option>
                                @php $types = \App\Enums\GeneralEnums::SubsidiaryTypes[app()->getLocale()]; @endphp
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
                            <label for="img">{{ trans('cruds.' . $path . '.' . 'img') }}</label>
                            <input type="file" class="form-control-file" id="img" name="img">
                            @if ($errors->has('img'))
                                <span class="text-danger">{{ $errors->first('img') }}</span>
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
