<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\GeneralEnums;
use App\Models\Project as Model;
use App\Http\Requests\Dashboard\Create\CreateUnitRequest as CreateRequest;
use App\Http\Requests\Dashboard\Update\UpdateUnitRequest as UpdateRequest;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    protected $itemPerPage = GeneralEnums::ITEM_PER_PAGE;
    protected $path = 'units';

    /**
     * Get All Records
     * @param Request $request
     */
    public function index(Request $request)
    {
        abort_if(!canPass($this->path . '_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $query = Model::orderBy('order', 'ASC')
                ->whereNotNull('parent_id');

            // Filter data based on query string parameters
            if ($request->has('filter')) {
                $filters = $request->input('filter');
                foreach ($filters as $column => $value) {
                    $query->where($column, $value);
                }
            }

            $records = $query->paginate(GeneralEnums::ITEM_PER_PAGE);
            $path = 'units';
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
            $path = 'units';
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
            $path = 'units';
            $projects = Model::whereIsActive(true)
                ->whereNull('parent_id')
                ->get();
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
            $mainPath = Model::FILE_UPLOAD_PATH;
            if ($request->has('map') && $request->map  != null) {
                $fileName = uploadMedia($request->map, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'map',
                    $request->map->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->map->getSize()
                );
            }

            if ($request->has('image') && $request->image  != null) {
                $fileName = uploadMedia($request->image, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'image',
                    $request->image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image->getSize()
                );
            }

            if ($request->has('image_mobile') && $request->image_mobile  != null) {
                $fileName = uploadMedia($request->image_mobile, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'image_mobile',
                    $request->image_mobile->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image_mobile->getSize()
                );
            }

            if ($request->has('video') && $request->video  != null) {
                $fileName = uploadMedia($request->video, $mainPath);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'video',
                    $request->video->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->video->getSize()
                );
            }


            if ($request->has('rendered_images') && is_array($request->rendered_images)) {
                foreach ($request->rendered_images as $renderImages) {
                    $fileName = uploadMedia($renderImages, $mainPath);

                    (new FileService)->addFile(
                        $record,
                        $fileName,
                        $mainPath,
                        'rendered_images',
                        $renderImages->getClientOriginalExtension(),
                        'attachments',
                        fileSize: $renderImages->getSize()
                    );
                }
            }

            if ($request->has('rendered_images_mobile') && is_array($request->rendered_images_mobile)) {
                foreach ($request->rendered_images_mobile as $renderImages) {
                    $fileName = uploadMedia($renderImages, $mainPath);

                    (new FileService)->addFile(
                        $record,
                        $fileName,
                        $mainPath,
                        'rendered_images_mobile',
                        $renderImages->getClientOriginalExtension(),
                        'attachments',
                        fileSize: $renderImages->getSize()
                    );
                }
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
            $path = 'units';
            $record = Model::findOrFail($id);
            $projects = Model::whereIsActive(true)
                ->whereNull('parent_id')
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
            $mainPath = Model::FILE_UPLOAD_PATH;
            if ($request->has('map') && $request->map  != null) {
                if ($record->map != null) {
                    (new FileService)->deleteFile(
                        $record->map,
                        $mainPath,
                        'map',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->map, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
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
                        $mainPath,
                        'image',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->image, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
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
                        $mainPath,
                        'image_mobile',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->image_mobile, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'image_mobile',
                    $request->image_mobile->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->image_mobile->getSize()
                );
            }

            if ($request->has('video') && $request->video  != null) {
                if ($record->video != null) {
                    (new FileService)->deleteFile(
                        $record->video,
                        $mainPath,
                        'video',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->video, $mainPath);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $mainPath,
                    'video',
                    $request->video->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->video->getSize()
                );
            }

            if ($request->has('rendered_images') && is_array($request->rendered_images)) {
                foreach ($request->rendered_images as $renderImages) {
                    $fileName = uploadMedia($renderImages, $mainPath);

                    (new FileService)->addFile(
                        $record,
                        $fileName,
                        $mainPath,
                        'rendered_images',
                        $renderImages->getClientOriginalExtension(),
                        'attachments',
                        fileSize: $renderImages->getSize()
                    );
                }
            }

            if ($request->has('rendered_images_mobile') && is_array($request->rendered_images_mobile)) {
                foreach ($request->rendered_images_mobile as $renderImages) {
                    $fileName = uploadMedia($renderImages, $mainPath);

                    (new FileService)->addFile(
                        $record,
                        $fileName,
                        $mainPath,
                        'rendered_images_mobile',
                        $renderImages->getClientOriginalExtension(),
                        'attachments',
                        fileSize: $renderImages->getSize()
                    );
                }
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
     * @param string $key
     */
    public function toggleActivity($id, $key)
    {
        abort_if(!canPass($this->path . '_toggleActivity'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $record = Model::findOrFail($id);
            $record->{"$key"} = !$record->{"$key"};
            $record->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }

    /**
     * Delete Image from Record
     * @param int $id
     * @param string $file_name
     * @param string $label
     */
    public function deleteImage($id)
    {
        abort_if(!canPass($this->path . '_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $fileName = explode('/', request()->file_name);
            $fileName = end($fileName);
            (new FileService)->deleteFile(request()->file_name, Model::FILE_UPLOAD_PATH, request()->label, $id);
            deleteFile($fileName, Model::FILE_UPLOAD_PATH);
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            abort(500);
        }
    }
}
