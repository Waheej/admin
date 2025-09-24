<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\GeneralEnums;
use App\Models\SEO as Model;
use App\Http\Requests\Dashboard\Create\CreateSEORequest as CreateRequest;
use App\Http\Requests\Dashboard\Update\UpdateSEORequest as UpdateRequest;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SeoController extends Controller
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
            $data = $request->validated();
            $data['keywords_en'] = array_map('trim', explode(',', $request->keywords_en));
            $data['keywords_ar'] = array_map('trim', explode(',', $request->keywords_ar));
            $record = Model::create($data);
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

            if ($request->has('og_image') && $request->og_image  != null) {
                $fileName = uploadMedia($request->og_image, $this->path);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'og_image',
                    $request->og_image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->og_image->getSize()
                );
            }

            if ($request->has('twitter_image') && $request->twitter_image  != null) {
                $fileName = uploadMedia($request->twitter_image, $this->path);
                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'twitter_image',
                    $request->twitter_image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->twitter_image->getSize()
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
            $data = $request->validated();
            $data['keywords_en'] = array_map('trim', explode(',', $request->keywords_en));
            $data['keywords_ar'] = array_map('trim', explode(',', $request->keywords_ar));
            $record->update($data);

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

            if ($request->has('og_image') && $request->og_image  != null) {
                if ($record->og_image != null) {
                    (new FileService)->deleteFile(
                        $record->og_image,
                        $this->path,
                        'og_image',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->og_image, $this->path);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'og_image',
                    $request->og_image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->og_image->getSize()
                );
            }

            if ($request->has('twitter_image') && $request->twitter_image  != null) {
                if ($record->twitter_image != null) {
                    (new FileService)->deleteFile(
                        $record->twitter_image,
                        $this->path,
                        'twitter_image',
                        $record->id
                    );
                }
                $fileName = uploadMedia($request->twitter_image, $this->path);

                (new FileService)->addFile(
                    $record,
                    $fileName,
                    $this->path,
                    'twitter_image',
                    $request->twitter_image->getClientOriginalExtension(),
                    'attachments',
                    fileSize: $request->twitter_image->getSize()
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
