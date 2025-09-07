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
            <form action="{{ route('admin.admins.updatePermissions', $user->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 style="font-size: 1.1rem;font-weight: 400;">
                                    {{ $user->full_name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.' . $path . '.module') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.' . $path . '.permissions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $key => $record)
                                    <tr>
                                        <td class="text-center">
                                            <div>
                                                {{ trans('cruds.' . $key . '.title_plural') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @foreach ($record as $permission)
                                                <div class="checkbox" style="display:inline-block">
                                                    <label for="permission-{{ $permission->id }}">
                                                        <input type="checkbox" value="{{ $permission->id }}"
                                                            name="permissions[]"
                                                            id="permission-{{ $permission->id }}"{{ $permission->has_permission ? ' checked' : '' }}>
                                                        @php
                                                            $per = explode(' ', $permission->title_en);
                                                            $action = end($per);
                                                        @endphp
                                                        {{ isset(\App\Enums\GeneralEnums::PermissionActions[app()->getLocale()][$action])
                                                            ? \App\Enums\GeneralEnums::PermissionActions[app()->getLocale()][$action]
                                                            : $action }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn button-purple">{{ trans('global.update') }}</button>
                </div>
            </form>


            <!-- /.card-body -->
            <!-- pagination start -->
            <!-- pagination end -->
    </div>
    <!-- /.card -->

    </section>
    <!-- /.content -->
    </div>
    <script>
        function submitform(id) {
            console.log(id)
            document.getElementById("activeForm-" + id).submit();
        }
    </script>
@endsection
