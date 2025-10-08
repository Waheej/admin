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
                            <label for="exampleInputNameEn">{{ trans('cruds.' . $path . '.' . 'name_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameEn"
                                value="{{ $record->name_en ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNameAr">{{ trans('cruds.' . $path . '.' . 'name_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameAr"
                                value="{{ $record->name_ar ?? '' }}" disabled>
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
                            <label for="exampleInputStatus">{{ trans('cruds.' . $path . '.' . 'status') }}</label>
                            <input type="text" class="form-control" id="exampleInputStatus"
                                value="{{ \App\Enums\GeneralEnums::ProjectStatuses[app()->getLocale()][$record->status] ?? '' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPrice">{{ trans('cruds.' . $path . '.' . 'price') }}</label>
                            <input type="text" class="form-control" id="exampleInputPrice"
                                value="{{ $record->price ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCity">{{ trans('cruds.' . $path . '.' . 'city') }}</label>
                            <input type="text" class="form-control" id="exampleInputCity"
                                value="{{ $record->city ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputApartmentType">{{ trans('cruds.' . $path . '.' . 'apartment_type') }}</label>
                            <input type="text" class="form-control" id="exampleInputApartmentType"
                                value="{{ $record->apartment_type ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputParentId">{{ trans('cruds.' . $path . '.' . 'parent_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputParentId"
                                value="{{ $record->parent ? $record->parent->{"name_".app()->getLocale()} : '' }}" disabled>
                        </div>
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
                        <!-- Map Section -->
                        <div class="form-group">
                            <label for="map">{{ trans('cruds.' . $path . '.' . 'location') }}</label>
                            <div id="map" style="height: 400px; border: 1px solid #ccc;"></div>
                        </div>

                        <!-- Map Display -->
                        <div class="form-group">
                            <label for="map">{{ trans('cruds.' . $path . '.' . 'map') }}</label>
                            <div>
                                @php
                                    $fileExtension = pathinfo($record->map, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $record->map }}" alt="Media Image"
                                        style="max-width: 300px; height: auto;">
                                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                                    <video width="320" height="240" controls>
                                        <source src="{{ $record->map }}" type="video/{{ $fileExtension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <p>{{ trans('cruds.' . $path . '.file_not_supported') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">{{ trans('cruds.' . $path . '.' . 'image') }}</label>
                            <div>
                                @php
                                    $fileExtension = pathinfo($record->image, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $record->image }}" alt="Media Image"
                                        style="max-width: 300px; height: auto;">
                                @else
                                    <p>{{ trans('cruds.' . $path . '.file_not_supported') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image_mobile">{{ trans('cruds.' . $path . '.' . 'image_mobile') }}</label>
                            <div>
                                @php
                                    $fileExtension = pathinfo($record->image_mobile, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $record->image_mobile }}" alt="Media Image"
                                        style="max-width: 300px; height: auto;">
                                @else
                                    <p>{{ trans('cruds.' . $path . '.file_not_supported') }}</p>
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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var lat = {{ $record->lat ?? 0 }};
        var long = {{ $record->long ?? 0 }};
        var map = L.map('map').setView([lat, long], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        L.marker([lat, long]).addTo(map).bindPopup("Location").openPopup();
    </script>
@endsection
