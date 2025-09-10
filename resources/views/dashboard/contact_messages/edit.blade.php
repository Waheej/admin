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

                <form role="form" method="POST" action="{{ route('admin.contact_messages.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputName">{{ trans('cruds.' . $path . '.' . 'name') }}</label>
                            <input type="text" class="form-control" id="exampleInputName" name="{{ 'name' }}"
                                value="{{ old('name', $record->name) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'name') }}" readonly>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label
                                for="exampleInputCountryCode">{{ trans('cruds.' . $path . '.' . 'country_code') }}</label>
                            <input type="text" class="form-control" id="exampleInputCountryCode"
                                name="{{ 'country_code' }}" value="{{ old('country_code', $record->country_code) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'country_code') }}" readonly>
                            @if ($errors->has('country_code'))
                                <span class="text-danger">{{ $errors->first('country_code') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMobile">{{ trans('cruds.' . $path . '.' . 'mobile') }}</label>
                            <input type="text" class="form-control" id="exampleInputMobile" name="{{ 'mobile' }}"
                                value="{{ old('mobile', $record->mobile) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'mobile') }}" readonly>
                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">{{ trans('cruds.' . $path . '.' . 'email') }}</label>
                            <input type="text" class="form-control" id="exampleInputEmail" name="{{ 'email' }}"
                                value="{{ old('email', $record->email) }}" placeholder="{{ trans('cruds.' . $path . '.' . 'email') }}"
                                readonly>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputMessage">{{ trans('cruds.' . $path . '.' . 'message') }}</label>
                            <input type="text" class="form-control" id="exampleInputMessage" name="{{ 'message' }}"
                                value="{{ old('message', $record->message) }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'message') }}" readonly>
                            @if ($errors->has('message'))
                                <span class="text-danger">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputProjectId">{{ trans('cruds.' . $path . '.' . 'project_id') }}</label>
                            <input type="text" class="form-control" id="exampleInputProjectId"
                                name="{{ 'project_id' }}"
                                value="{{ $record->project ? $record->project->{'name_' . app()->getLocale()} : '' }}"
                                placeholder="{{ trans('cruds.' . $path . '.' . 'project_id') }}" readonly>
                            @if ($errors->has('project_id'))
                                <span class="text-danger">{{ $errors->first('project_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status">{{ trans('cruds.' . $path . '.' . 'status') }}</label>
                            <select class="form-control" id="status" name="status"
                                {{ old('status', $record->status) == 'opened' ? 'disabled' : '' }}>
                                @foreach (\App\Enums\GeneralEnums::ContactMessageStatuses[app()->getLocale()] as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('status', $record->status) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
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
    <script></script>
@endsection
