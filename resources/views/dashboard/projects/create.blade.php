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
                <form role="form" method="POST" action="{{ route('admin.projects.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputNameEn">{{ trans('cruds.' . $path . '.' . 'name_en') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameEn" name="{{ 'name_en' }}"
                                value="{{ old('name_en') }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'name_en') }}">
                            @if ($errors->has('name_en'))
                                <span class="text-danger">{{ $errors->first('name_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNameAr">{{ trans('cruds.' . $path . '.' . 'name_ar') }}</label>
                            <input type="text" class="form-control" id="exampleInputNameAr" name="{{ 'name_ar' }}"
                                value="{{ old('name_ar') }}"
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
                            <label for="exampleInputType">{{ trans('cruds.' . $path . '.' . 'status') }}</label>
                            <select class="form-control" id="exampleInputStatus" name="status">
                                <option value="" disabled selected>
                                    {{ __('global.please_select', ['col' => trans('cruds.' . $path . '.status')]) }}
                                </option>
                                @php $statuses = \App\Enums\GeneralEnums::ProjectStatuses[app()->getLocale()]; @endphp
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPrice">{{ trans('cruds.' . $path . '.' . 'price') }}</label>
                            <input type="number" class="form-control" id="exampleInputPrice" name="{{ 'price' }}"
                                value="{{ old('price') }}" placeholder="{{ trans('cruds.' . $path . '.' . 'price') }}">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>

                         <!-- Latitude and Longitude with Leaflet Map -->
                        <div class="form-group">
                            <label for="map">{{ trans('cruds.' . $path . '.' . 'location') }}</label>
                            <div id="map" style="height: 400px; border: 1px solid #ccc;"></div>
                            <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                            <input type="hidden" id="long" name="long" value="{{ old('long') }}">
                            @if ($errors->has('lat'))
                                <span class="text-danger">{{ $errors->first('lat') }}</span>
                            @endif
                            @if ($errors->has('long'))
                                <span class="text-danger">{{ $errors->first('long') }}</span>
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
     <!-- Include Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([30.0444, 31.2357], 13); // Default to Cairo

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Add a marker
        var marker = L.marker([30.0444, 31.2357], {
            draggable: true
        }).addTo(map);

        // Update hidden inputs when marker is dragged
        marker.on('dragend', function(e) {
            var latLng = marker.getLatLng();
            document.getElementById('lat').value = latLng.lat;
            document.getElementById('long').value = latLng.lng;
        });

        // Update marker when clicking on the map
        map.on('click', function(e) {
            var latLng = e.latlng;
            marker.setLatLng(latLng);
            document.getElementById('lat').value = latLng.lat;
            document.getElementById('long').value = latLng.lng;
        });
    </script>
@endsection
