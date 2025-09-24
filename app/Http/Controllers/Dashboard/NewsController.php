<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\GeneralEnums;
use App\Models\InfoPage as Model;
use App\Http\Requests\Dashboard\Create\CreateNewsRequest as CreateRequest;
use App\Http\Requests\Dashboard\Update\UpdateNewsRequest as UpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected $itemPerPage = GeneralEnums::ITEM_PER_PAGE;
    protected $path = 'news';

    /**
     * Get All Records
     * @param Request $request
     */
    public function index(Request $request)
    {
        abort_if(!canPass($this->path . '_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $query = Model::whereType('news')->orderBy('id', 'DESC');

            // Filter data based on query string parameters
            if ($request->has('filter')) {
                $filters = $request->input('filter');
                foreach ($filters as $column => $value) {
                    $query->where($column, $value);
                }
            }

            $records = $query->paginate(GeneralEnums::ITEM_PER_PAGE);
            $path = 'news';
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
            $record = Model::whereType('news')->whereId($id)->first();

            if (!$record) {
                abort(404);
            }

            $path = 'news';
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
            $path = 'news';
            $projects = Project::whereIsActive(true)->get();
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
            $data = $request->validated();
            $data['type'] = 'news';
            $mainPath = Model::FILE_UPLOAD_PATH;
            $record = Model::create($data);
            if ($request->has('media_path') && $request->media_path  != null) {
                $fileName = uploadMedia($request->media_path, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'media_path',
                    $request->media_path->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->media_path->getSize()
                );
            }

            if ($request->has('mobile_media_path') && $request->mobile_media_path  != null) {
                $fileName = uploadMedia($request->mobile_media_path, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'mobile_media_path',
                    $request->mobile_media_path->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->mobile_media_path->getSize()
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
            $record = Model::whereType('news')->whereId($id)->first();

            if (!$record) {
                abort(404);
            }

            $path = 'news';
            $projects = Project::whereIsActive(true)->get();
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
            $mainPath = Model::FILE_UPLOAD_PATH;

            if ($request->has('media_path') && $request->media_path  != null) {
                if ($record->media_path != null) {
                    (new FileService)->deleteFile(
                        $record->media_path,
                        $mainPath,
                        'media_path',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->media_path, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'media_path',
                    $request->media_path->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->media_path->getSize()
                );
            }

            if ($request->has('mobile_media_path') && $request->mobile_media_path  != null) {
                if ($record->mobile_media_path != null) {
                    (new FileService)->deleteFile(
                        $record->mobile_media_path,
                        $mainPath,
                        'mobile_media_path',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->mobile_media_path, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'mobile_media_path',
                    $request->mobile_media_path->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->mobile_media_path->getSize()
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
