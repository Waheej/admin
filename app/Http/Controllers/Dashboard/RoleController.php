<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\GeneralEnums;
use App\Models\Role as Model;
use App\Http\Requests\Dashboard\Create\CreateRoleRequest as CreateRequest;
use App\Http\Requests\Dashboard\Update\UpdateRoleRequest as UpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $itemPerPage = GeneralEnums::ITEM_PER_PAGE;
    protected $path = Model::FILE_UPLOAD_PATH;

    /**
     * Get All Records
     * @param Request $request
     */
    public function index(Request $request)
    {
        abort_if(!canPass($this->path . '_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $query = Model::orderBy('id', 'DESC');

            // Filter data based on query string parameters
            if ($request->has('filter')) {
                $filters = $request->input('filter');
                foreach ($filters as $column => $value) {
                    $query->where($column, $value);
                }
            }

            $records = $query->paginate(GeneralEnums::ITEM_PER_PAGE);
            $path = Model::FILE_UPLOAD_PATH;
            return view('dashboard.' . $this->path . '.index', compact('records', 'path'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * show record by id
     * @param $id
     */
    public function show($id)
    {
        abort_if(!canPass($this->path . '_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::find($id);
            $path = Model::FILE_UPLOAD_PATH;
            return view('dashboard.' . $this->path . '.show', compact('record', 'path'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Show Create a New Record Page
     */
    public function create()
    {
        abort_if(!canPass($this->path . '_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $path = Model::FILE_UPLOAD_PATH;
            return view('dashboard.' . $this->path . '.create', compact('path'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }


    /**
     * Create a New Record
     * @param CreateRequest $request
     */

    public function store(CreateRequest $request)
    {
        abort_if(!canPass($this->path . '_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            Model::create($request->validated());
            return redirect(route('admin.' . $this->path . '.index'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }


    /**
     * Show Edit Record Page
     * @param int $id
     */
    public function edit($id)
    {
        abort_if(!canPass($this->path . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $path = Model::FILE_UPLOAD_PATH;
            $record = Model::findOrFail($id);
            return view('dashboard.' . $this->path . '.edit', compact('record', 'path'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Update an Existing Record
     * @param UpdateRequest $request
     * @param int $id
     */
    public function update(UpdateRequest $request, $id)
    {
        abort_if(!canPass($this->path . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::findOrFail($id);
            $record->update($request->validated());
            return redirect(route('admin.' . $this->path . '.index'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Delete an Existing Record
     * @param int $id
     */
    public function destroy($id)
    {
        abort_if(!canPass($this->path . '_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::findOrFail($id);
            $record->delete();
            return redirect(route('admin.' . $this->path . '.index'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Toggle Activity an Existing Record
     * @param int $id
     */
    public function toggleActivity($id)
    {
        abort_if(!canPass($this->path . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::findOrFail($id);
            $record->is_active = !$record->is_active;
            $record->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * get Permissions
     * @param int $id
     */
    public function permissions($id)
    {
        abort_if(!canPass($this->path . '_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $path = Model::FILE_UPLOAD_PATH;
            $record = Model::find($id);

            $rolePermissions = Model::findOrFail($id)->permissions->pluck('permission')->toArray();
            $allPermissions = Permission::get();
            $permissions = [];
            foreach ($allPermissions as $permission) {
                $action = explode('.', $permission->route);
                if (in_array(end($action), ['store', 'update', 'updatePermissions', 'logout'])) {
                    continue;
                }
                $permission['has_permission'] = false;

                if (in_array($permission->permission, $rolePermissions)) {
                    $permission['has_permission'] = true;
                }
                $permissions[] = $permission;
            }

            $records = collect($permissions)->groupBy('group');
            return view('dashboard.' . $this->path . '.permissions', compact('records', 'path', 'record'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Update Permissions
     * @param int $id
     */
    public function updatePermissions(Request $request, $id)
    {
        abort_if(!canPass($this->path . '_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::find($id);
            $record->permissions()->sync($request->permissions);
            return redirect()->back()->with(trans('messages.updated_successfully'));
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }
}
