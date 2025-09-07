<?php

namespace App\Http\Controllers;

use App\Enums\GeneralEnums;
use App\Enums\MapEnums;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class GeneralController
 *
 * This class defines general-purpose API endpoints for retrieving Dynamic Data Lists (DDL) related to Models and Enums.
 *
 * @package App\Http\Controllers
 */

class GeneralController extends Controller
{
    /**
     * DDL list for a given Model and Col records
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modelDDLList(Request $request)
    {
        try {
            if (in_array($request->model_name, array_keys(ModelsMap()))) {
                $cols = $request->cols;
                $fillable = (new (ModelsMap()[$request->model_name]))->getFillable();
                $query = (ModelsMap()[$request->model_name])::orderBy('id', 'DESC');

                if ($cols) {
                    foreach ($cols as $col) {
                        if (!in_array($col, $fillable)) {
                            return apiResponse(
                                true,
                                trans('messages.field_not_found'),
                                Response::HTTP_BAD_REQUEST
                            );
                        }

                        if (($request->has('searchWord')) && ($request->searchWord != '') && ($request->searchWord != null)) {
                            $query = $query->orWhere($col, 'LIKE', "%$request->searchWord%");
                        }
                    }

                    array_push($cols, 'id');
                    $query = $query->select($cols);

                    if (in_array('is_active', $fillable)) {
                        $query = $query->whereIsActive(true);
                    }
                } else {
                    if (in_array('is_active', $fillable)) {
                        $query = $query->whereIsActive(true);
                    }

                    foreach ($fillable as $col) {
                        if (($request->has('searchWord')) && ($request->searchWord != '') && ($request->searchWord != null)) {
                            $query = $query->orWhere($col, 'LIKE', "%$request->searchWord%");
                        }
                    }
                }

                if (($request->has('filters')) && (!empty($request->filters)) && ($request->filters != null)) {
                    foreach ($request->filters as $key => $filter) {
                        if (in_array($key, $fillable)) {
                            $query = $query->where($key, $filter);
                        }
                    }
                }

                $isPaginate = $request->has('isPaginate') && ($request->isPaginate == 1);

                if ($isPaginate) {
                    $itemPerPage = GeneralEnums::ITEM_PER_PAGE;

                    if ($request->has('itemPerPage') && ($request->itemPerPage != null)) {
                        $itemPerPage = $request->itemPerPage;
                    }

                    $data = $query->paginate($itemPerPage);
                    $paginationData = getPaginationData($data);
                    $records = $query->get();
                } else {
                    $records['records'] = $query->get();
                }

                return apiResponse(
                    true,
                    '',
                    Response::HTTP_OK,
                    $records,
                    isset($paginationData) ? $paginationData : null
                );
            }
            return apiResponse(
                true,
                trans('messages.model_not_found'),
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * DDL list for a given Enum
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enumDDLList(Request $request)
    {
        try {
            if (in_array($request->enum_name, array_keys(MapEnums::EnumsMap))) {
                $records = MapEnums::EnumsMap[$request->enum_name];

                $data = [];
                if ((in_array('ar', array_keys($records))) || (in_array('en', array_keys($records)))) {
                    foreach ($records[app()->getLocale()] as $key => $value) {
                        $record = [
                            'key' => $key,
                            'value' => $value
                        ];
                        if (is_array($value)) {
                            $record = [
                                'key' => $key,
                                'value' => $value['title'],
                                'logo' => $value['logo'] ? asset('images/property_types/' . $value['logo']) : null,
                            ];
                        }
                        array_push($data, $record);
                    }
                } else {
                    foreach ($records as $key => $value) {
                        $record = [
                            'key' => $key,
                            'value' => $value
                        ];
                        array_push($data, $record);
                    }
                }
                $enumData['records'] = $data;
                return apiResponse(
                    true,
                    '',
                    Response::HTTP_OK,
                    $enumData
                );
            }
            return apiResponse(
                true,
                trans('messages.enum_not_found'),
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * General Search
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $model = $this->getModelName($request->model_name);
            if (class_exists('\\App\\Models\\' . $model)) {
                $cols = [];
                // array_push($cols, 'id');
                if (isset($request->cols)) {
                    foreach ($request->cols as $col) {
                        array_push($cols, $col);
                    }
                } else {
                    $modelInstance = new ('\\App\\Models\\' . $model);
                    $cols = $modelInstance->getFillable();
                }
                array_push($cols, 'id');
                $query = ('\\App\\Models\\' . $model)::select($cols);

                // Perform search if search query parameter is provided
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    foreach ($cols as $col) {
                        $query->orWhere($col, 'LIKE', "%$searchTerm%");
                    }
                }
                $records = $query->get();
                return apiResponse(
                    true,
                    '',
                    200,
                    $records
                );
            }

            return apiResponse(
                true,
                trans('messages.model_not_found'),
                400
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

}
