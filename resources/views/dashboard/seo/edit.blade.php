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
                    action="{{ route('admin.seo.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputPage">{{ trans('cruds.' . $path . '.' . 'page') }}</label>
                            <select class="form-control" id="exampleInputPage" name="page">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.page')]) }}
                                </option>
                                @php $pages = \App\Enums\GeneralEnums::SEOPages[app()->getLocale()]; @endphp
                                @foreach ($pages as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('page', $record->page) == $key ? 'selected' : '' }}>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('page'))
                                <span class="text-danger">{{ $errors->first('page') }}</span>
                            @endif
                        </div>
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
                            @php
                                $keywordsEn = (array) $record->keywords_en;
                            @endphp
                            <label for="exampleInputKeywordsEn">{{ trans('cruds.' . $path . '.' . 'keywords_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputKeywordsEn"
                                name="{{ 'keywords_en' }}"
                                value="{{ isset($record->keywords_en) ? implode(' , ', $keywordsEn) : '' }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'keywords_en') }}">
                            @if ($errors->has('keywords_en'))
                                <span class="text-danger">{{ $errors->first('keywords_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @php
                                $keywordsAr = (array) $record->keywords_ar;
                            @endphp
                            <label for="exampleInputKeywordsAr">{{ trans('cruds.' . $path . '.' . 'keywords_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputKeywordsAr"
                                name="{{ 'keywords_ar' }}"
                                value="{{ isset($record->keywords_ar) ? implode(' , ', $keywordsAr) : '' }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'keywords_ar') }}">
                            @if ($errors->has('keywords_ar'))
                                <span class="text-danger">{{ $errors->first('keywords_ar') }}</span>
                            @endif
                        </div>
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
                            <label for="exampleInputOgTitleEn">{{ trans('cruds.' . $path . '.' . 'og_title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgTitleEn"
                                name="{{ 'og_title_en' }}" value="{{ old('og_title_en', $record->og_title_en) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'og_title_en') }}">
                            @if ($errors->has('og_title_en'))
                                <span class="text-danger">{{ $errors->first('og_title_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOgTitleAr">{{ trans('cruds.' . $path . '.' . 'og_title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgTitleAr"
                                name="{{ 'og_title_ar' }}" value="{{ old('og_title_ar', $record->og_title_ar) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'og_title_ar') }}">
                            @if ($errors->has('og_title_ar'))
                                <span class="text-danger">{{ $errors->first('og_title_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="og_description_en">
                                {{ trans('cruds.' . $path . '.' . 'og_description_en') }}
                            </label>
                            <textarea class="form-control" id="og_description_en" name="og_description_en"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'og_description_en') }}">
                                    {{ old('og_description_en', $record->og_description_en) }}
                                </textarea>

                            @if ($errors->has('og_description_en'))
                                <span class="text-danger">{{ $errors->first('og_description_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="og_description_ar">
                                {{ trans('cruds.' . $path . '.' . 'og_description_ar') }}
                            </label>
                            <textarea class="form-control" id="og_description_ar" name="og_description_ar"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'og_description_ar') }}">
                                    {{ old('og_description_ar', $record->og_description_ar) }}
                                </textarea>

                            @if ($errors->has('og_description_ar'))
                                <span class="text-danger">{{ $errors->first('og_description_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOgUrl">{{ trans('cruds.' . $path . '.' . 'og_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgUrl"
                                name="{{ 'og_url' }}" value="{{ old('og_url', $record->og_url) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'og_url') }}">
                            @if ($errors->has('og_url'))
                                <span class="text-danger">{{ $errors->first('og_url') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterTitleEn">{{ trans('cruds.' . $path . '.' . 'twitter_title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterTitleEn"
                                name="{{ 'twitter_title_en' }}"
                                value="{{ old('twitter_title_en', $record->twitter_title_en) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'twitter_title_en') }}">
                            @if ($errors->has('twitter_title_en'))
                                <span class="text-danger">{{ $errors->first('twitter_title_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterTitleAr">{{ trans('cruds.' . $path . '.' . 'twitter_title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterTitleAr"
                                name="{{ 'twitter_title_ar' }}"
                                value="{{ old('twitter_title_ar', $record->twitter_title_ar) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'twitter_title_ar') }}">
                            @if ($errors->has('twitter_title_ar'))
                                <span class="text-danger">{{ $errors->first('twitter_title_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="twitter_description_en">
                                {{ trans('cruds.' . $path . '.' . 'twitter_description_en') }}
                            </label>
                            <textarea class="form-control" id="twitter_description_en" name="twitter_description_en"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'twitter_description_en') }}">
                                    {{ old('twitter_description_en', $record->twitter_description_en) }}
                                </textarea>

                            @if ($errors->has('twitter_description_en'))
                                <span class="text-danger">{{ $errors->first('twitter_description_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="twitter_description_ar">
                                {{ trans('cruds.' . $path . '.' . 'twitter_description_ar') }}
                            </label>
                            <textarea class="form-control" id="twitter_description_ar" name="twitter_description_ar"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'twitter_description_ar') }}">
                                    {{ old('twitter_description_ar', $record->twitter_description_ar) }}
                                </textarea>

                            @if ($errors->has('twitter_description_ar'))
                                <span class="text-danger">{{ $errors->first('twitter_description_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterUrl">{{ trans('cruds.' . $path . '.' . 'twitter_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterUrl"
                                name="{{ 'twitter_url' }}" value="{{ old('twitter_url', $record->twitter_url) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'twitter_url') }}">
                            @if ($errors->has('twitter_url'))
                                <span class="text-danger">{{ $errors->first('twitter_url') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputCanonicalUrl">{{ trans('cruds.' . $path . '.' . 'canonical_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputCanonicalUrl"
                                name="{{ 'canonical_url' }}" value="{{ old('canonical_url', $record->canonical_url) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'canonical_url') }}">
                            @if ($errors->has('canonical_url'))
                                <span class="text-danger">{{ $errors->first('canonical_url') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputRobots">{{ trans('cruds.' . $path . '.' . 'robots') }}</label>
                            <input type="text" class="form-control" id="exampleInputRobots"
                                name="{{ 'robots' }}" value="{{ old('robots', $record->robots) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'robots') }}">
                            @if ($errors->has('robots'))
                                <span class="text-danger">{{ $errors->first('robots') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="Image">{{ trans('cruds.' . $path . '.' . 'image') }}</label>
                            <input type="file" class="form-control-file" id="Image" name="image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="OGImage">{{ trans('cruds.' . $path . '.' . 'og_image') }}</label>
                            <input type="file" class="form-control-file" id="mobileImage" name="og_image">
                            @if ($errors->has('og_image'))
                                <span class="text-danger">{{ $errors->first('og_image') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="TwitterImage">{{ trans('cruds.' . $path . '.' . 'twitter_image') }}</label>
                            <input type="file" class="form-control-file" id="TwitterImage" name="twitter_image">
                            @if ($errors->has('twitter_image'))
                                <span class="text-danger">{{ $errors->first('twitter_image') }}</span>
                            @endif
                        </div>
                        <div>
                            <button class="btn button-purple btn-lg"
                                type="submit">{{ trans('global.update') }}</button>
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
        ClassicEditor
            .create(document.querySelector('#og_description_en'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
        ClassicEditor
            .create(document.querySelector('#og_description_ar'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
        ClassicEditor
            .create(document.querySelector('#twitter_description_en'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
        ClassicEditor
            .create(document.querySelector('#twitter_description_ar'))
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
@endsection
