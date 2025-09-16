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
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 style="font-size: 1.1rem;font-weight: 400;">{{ trans('cruds.' . $path . '.title_plural') }}
                            </h3>
                        </div>
                        @if (canPass($path . '_create'))
                            <div class="col-6">
                                <div style="display: flex; justify-content: flex-end;">
                                    <a class="btn button-purple btn-sm" href="{{ route('admin.' . $path . '.create') }}">
                                        <i class="fa fa-plus"></i> {{ trans('global.new_record') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body  table-responsive p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>

                                <th class="text-center">
                                    {{ trans('cruds.' . $path . '.' . 'url') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.' . $path . '.' . 'name_en') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.' . $path . '.' . 'name_ar') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.' . $path . '.' . 'type') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.' . $path . '.' . 'is_active') }}
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>
                                        {{ $record->id }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ $record->url }}" target="_blank">{{ $record->url }}</a>
                                    </td>
                                    <td class="text-center">
                                        {{ $record->name_en }}
                                    </td>
                                    <td class="text-center">
                                        {{ $record->name_ar }}
                                    </td>
                                    <td class="text-center">
                                        {{ \App\Enums\GeneralEnums::SubsidiaryTypes[app()->getLocale()][$record->type] }}
                                    </td>
                                    @if (canPass($path . '_toggleActivity'))
                                        <td class="text-center" style="padding-top: 1%;">
                                            <form id="{{ 'activeForm-' . $record->id }}"
                                                action="{{ route('admin.' . $path . '.toggleActivity', $record->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <label class="switch">
                                                <input onchange="submitActiveForm({{ $record->id }})" type="checkbox"
                                                    {{ $record->is_active == true ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    @endif

                                    <td class="project-actions text-right">
                                        @if (canPass($path . '_show'))
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.' . $path . '.show', $record->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        @if (canPass($path . '_edit'))
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('admin.' . $path . '.edit', $record->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        @if (canPass($path . '_destroy'))
                                            <a class="btn btn-danger btn-sm text-white"
                                                onclick="submitDeleteForm({{ $record->id }})">
                                                <form id="{{ 'deleteForm-' . $record->id }}"
                                                    action="{{ route('admin.' . $path . '.destroy', $record->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $records->links('layouts.custom-pagination') }}
            </div>

            <!-- /.card-body -->
            <!-- pagination start -->
            <!-- pagination end -->
    </div>
    <!-- /.card -->

    </section>
    <!-- /.content -->
    </div>
    <script>
        function submitActiveForm(id) {
            document.getElementById("activeForm-" + id).submit();
        }

        function submitDeleteForm(id) {
            document.getElementById("deleteForm-" + id).submit();
        }
    </script>
@endsection
