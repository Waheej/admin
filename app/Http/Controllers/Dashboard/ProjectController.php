<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\GeneralEnums;
use App\Models\Project as Model;
use App\Http\Requests\Dashboard\Create\CreateProjectRequest as CreateRequest;
use App\Http\Requests\Dashboard\Update\UpdateProjectRequest as UpdateRequest;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
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

            $query = Model::orderBy('order', 'ASC');

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
            $projects = Model::whereIsActive(true)->get();
            return view('dashboard.' . $this->path . '.create', compact('path', 'projects'));
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
            $record = Model::create($request->validated());
            if ($request->has('map') && $request->map  != null) {
                $fileName = uploadMedia($request->map, $this->path);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'map',
                    $request->map->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->map->getSize()
                );
            }

            if ($request->has('image') && $request->image  != null) {
                $fileName = uploadMedia($request->image, $this->path);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'image',
                    $request->image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image->getSize()
                );
            }

            if ($request->has('image_mobile') && $request->image_mobile  != null) {
                $fileName = uploadMedia($request->image_mobile, $this->path);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'image_mobile',
                    $request->image_mobile->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image_mobile->getSize()
                );
            }
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
            $projects = Model::whereIsActive(true)
                ->where('id', '!=', $id)
                ->get();
            return view('dashboard.' . $this->path . '.edit', compact('record', 'path', 'projects'));
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
            if ($request->has('map') && $request->map  != null) {
                if ($record->map != null) {
                    (new FileService)->deleteFile(
                        $record->map,
                        $this->path,
                        'map',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->map, $this->path);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'map',
                    $request->map->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->map->getSize()
                );
            }

            if ($request->has('image') && $request->image  != null) {
                if ($record->image != null) {
                    (new FileService)->deleteFile(
                        $record->image,
                        $this->path,
                        'image',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->image, $this->path);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'image',
                    $request->image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image->getSize()
                );
            }

            if ($request->has('image_mobile') && $request->image_mobile  != null) {
                if ($record->image_mobile != null) {
                    (new FileService)->deleteFile(
                        $record->image_mobile,
                        $this->path,
                        'image_mobile',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->image_mobile, $this->path);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'image_mobile',
                    $request->image_mobile->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image_mobile->getSize()
                );
            }
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
}
