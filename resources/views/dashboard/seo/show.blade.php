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
                            <label for="exampleInputPage">{{ trans('cruds.' . $path . '.' . 'page') }}</label>
                            <input type="text" class="form-control" id="exampleInputPage"
                                value="{{ $record->page ? \App\Enums\GeneralEnums::SEOPages[app()->getLocale()][$record->page] : '' }}"
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
                            @php
                                $keywordsEn = (array) $record->keywords_en;
                            @endphp
                            <label for="exampleInputKeywordsEn">{{ trans('cruds.' . $path . '.' . 'keywords_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputKeywordsEn"
                                value="{{ isset($record->keywords_en) ? implode(' , ', $keywordsEn) : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            @php
                                $keywordsAr = (array) $record->keywords_ar;
                            @endphp
                            <label for="exampleInputKeywordsAr">{{ trans('cruds.' . $path . '.' . 'keywords_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputKeywordsAr"
                                value="{{ isset($record->keywords_ar) ? implode(' , ', $keywordsAr) : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUrl">{{ trans('cruds.' . $path . '.' . 'url') }}</label>
                            <input type="text" class="form-control" id="exampleInputUrl"
                                value="{{ $record->url ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOgTitleEn">{{ trans('cruds.' . $path . '.' . 'og_title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgTitleEn"
                                value="{{ $record->og_title_en ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOgTitleAr">{{ trans('cruds.' . $path . '.' . 'og_title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgTitleAr"
                                value="{{ $record->og_title_ar ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="og_description_en">
                                {{ trans('cruds.' . $path . '.' . 'og_description_en') }}
                            </label>
                            <div class="form-control" id="og_description_en" style="min-height: 150px; overflow-y: auto;">
                                {!! $record->og_description_en ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('og_description_en'))
                                <span class="text-danger">{{ $errors->first('og_description_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="og_description_ar">
                                {{ trans('cruds.' . $path . '.' . 'og_description_ar') }}
                            </label>
                            <div class="form-control" id="og_description_ar" style="min-height: 150px; overflow-y: auto;">
                                {!! $record->og_description_ar ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('og_description_ar'))
                                <span class="text-danger">{{ $errors->first('og_description_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOgUrl">{{ trans('cruds.' . $path . '.' . 'og_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputOgUrl"
                                value="{{ $record->og_url ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterTitleEn">{{ trans('cruds.' . $path . '.' . 'twitter_title_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterTitleEn"
                                value="{{ $record->twitter_title_en ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterTitleAr">{{ trans('cruds.' . $path . '.' . 'twitter_title_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterTitleAr"
                                value="{{ $record->twitter_title_ar ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="twitter_description_en">
                                {{ trans('cruds.' . $path . '.' . 'twitter_description_en') }}
                            </label>
                            <div class="form-control" id="twitter_description_en"
                                style="min-height: 150px; overflow-y: auto;">
                                {!! $record->twitter_description_en ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('twitter_description_en'))
                                <span class="text-danger">{{ $errors->first('twitter_description_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="twitter_description_ar">
                                {{ trans('cruds.' . $path . '.' . 'twitter_description_ar') }}
                            </label>
                            <div class="form-control" id="twitter_description_ar"
                                style="min-height: 150px; overflow-y: auto;">
                                {!! $record->twitter_description_ar ?? '<em>No description available</em>' !!}
                            </div>

                            @if ($errors->has('twitter_description_ar'))
                                <span class="text-danger">{{ $errors->first('twitter_description_ar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputTwitterUrl">{{ trans('cruds.' . $path . '.' . 'twitter_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputTwitterUrl"
                                value="{{ $record->twitter_url ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputCanonicalUrl">{{ trans('cruds.' . $path . '.' . 'canonical_url') }}</label>
                            <input type="text" class="form-control" id="exampleInputCanonicalUrl"
                                value="{{ $record->canonical_url ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputRobots">{{ trans('cruds.' . $path . '.' . 'robots') }}</label>
                            <input type="text" class="form-control" id="exampleInputRobots"
                                value="{{ $record->robots ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCreatedAt">{{ trans('cruds.' . $path . '.' . 'created_at') }}</label>
                            <input type="text" class="form-control" id="exampleInputCreatedAt"
                                value="{{ \Carbon\Carbon::parse($record->created_at)->diffForHumans() ?? '' }}" disabled>
                        </div>
                        {{-- Media --}}
                        <div class="form-group">
                            <div>
                                @if ($record->image)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'image') }} :</strong></p>
                                    <img src="{{ $record->image }}" alt="Image"
                                        style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                @endif
                                @if ($record->og_image)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'og_image') }} :</strong></p>
                                    <img src="{{ $record->og_image }}" alt="Image"
                                        style="max-width: 100%; height: auto; margin-bottom: 10px;">
                                @endif
                                @if ($record->twitter_image)
                                    <p><strong>{{ trans('cruds.' . $path . '.' . 'twitter_image') }} :</strong></p>
                                    <img src="{{ $record->twitter_image }}" alt="Image"
                                        style="max-width: 100%; height: auto; margin-bottom: 10px;">
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
