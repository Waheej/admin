<?php

use App\Models\File;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;

if (!function_exists('apiResponse')) {
    /**
     * Unified Api Response
     * @param bool $success
     * @param string $message
     * @param int $statusCode
     * @param array|object $data
     * @param array $paginationData
     * @param bool $showRecordsKey
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponse(bool $success, string $message, int $statusCode = Response::HTTP_OK, array|object $data = null, array $paginationData = null, bool $showRecordsKey = false): \Illuminate\Http\JsonResponse
    {
        if (($data == null) || ($data != null) && (empty($data))) {
            $data = json_decode("{}");
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $showRecordsKey ? ['records' => $data, 'pagination_data' => json_decode("{}")] : $data,
        ];

        if ($paginationData != null) {
            $response['data'] = [];
            $response['data']['records'] = $data;
            $response['data']['pagination_data'] = $paginationData;
        }

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('failResponse')) {
    /**
     * upload image in specific directory "storage"
     * @param $success
     * @param $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    function failResponse($error)
    {
        Log::error($error);

        $response =  [
            'success' => false,
            'message' => trans('messages.something_wrong'),
            'data' => '',
        ];

        return response()->json($response, 500);
    }
}



/**
 * Sends a HTTP request to the specified route using the given method, headers, and body.
 *
 * @param string $route The route to send the request to.
 * @param string $method The HTTP method to use for the request (e.g., GET, POST, PUT, DELETE).
 * @param array $headers (optional) Additional headers to include in the request.
 * @param array $body (optional) The body of the request.
 * @return mixed The response from the server, or a fail response if an error occurs.
 */

if (!function_exists('sendRequest')) {
    function sendRequest($route, $method, $headers = [], $body = [])
    {
        $client = new Client();
        $data = [];
        $headers += [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ];
        $data['headers'] = $headers;
        $url = $route;
        try {
            $response = $client->request($method, $url, [
                'connect_timeout' => 10,
                'body' => json_encode($body, JSON_PRESERVE_ZERO_FRACTION),
                'headers' => $headers
            ]);
            $response = json_decode($response->getBody(), true);
            return $response;
        } catch (ClientException $e) {
            // If it's a client exception, extract response from the exception
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                // Handle the response as needed
                return json_decode($response->getBody(), true);
            } else {
                // If no response is available, handle accordingly
                return ['error' => 'ClientException occurred without a response'];
            }
        } catch (\Exception $e) {
            return failResponse($e);
        }
    }
}

if (!function_exists('getValidationErrorData')) {
    /**
     * Get the validation error data.
     * @param $errors
     * @return array
     */
    function getValidationErrorData($errors)
    {
        $platform = request()->header('platform');

        if ($platform != 'mobile') {
            return ['errors' => $errors];
        }

        $errorData = [];
        foreach ($errors as $key => $values) {
            foreach ($values as $value) {
                $errorData[] = $value;
            }
        }
        return $errorData;
    }
}

if (!function_exists('uploadMedia')) {
    /**
     * upload File in specific directory "storage"
     * @param \Illuminate\Http\UploadedFile $upload
     * @param string $folder
     * @return string
     */
    function uploadMedia(\Illuminate\Http\UploadedFile $file, string $folder): string
    {

        $checkPath = '/' . $folder;

        $fileName = time() . $file->getClientOriginalName();
        Storage::disk(env('FILESYSTEM_DISK', 'local'))->put('public/' . $checkPath . '/' . $fileName, file_get_contents($file->getPathname()));
        return $fileName;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * delete File from storage
     * @param string $file
     * @param string $folder
     * @return bool
     */
    function deleteFile(string $file, string $folder): bool
    {
        $checkPath = '/' . $folder;
        return Storage::disk(env('FILESYSTEM_DISK', 'local'))->delete('public/' . $checkPath . '/' . $file);
    }
}



if (!function_exists('canPass')) {
    /**
     * check if current auth user has permission or not
     * @param string $permission
     * @return bool
     */
    function canPass(string $permission): bool
    {
        $userPermissions = auth()->user()->permissions()->pluck('permission')->toArray();
        return in_array($permission, $userPermissions);
    }
}


if (!function_exists('ModelsMap')) {
    /**
     * check if current auth user has permission or not
     * @param string $is_ddl
     * @return array
     */
    function ModelsMap(bool $is_ddl = false): array
    {
        $models = [];
        $files = array_diff(scandir(app_path('Models')), ['.', '..']);

        foreach ($files as $file) {
            $modelName = str_replace('.php', '', $file);
            $models[$modelName] = '\\App\\Models\\' . $modelName;
        }

        return $is_ddl ? array_keys($models) : $models;
    }
}

if (!function_exists('getPaginationData')) {
    /**
     * getPaginationData.
     * takes data and returns the pagination data
     *
     * @param mixed $data
     * @return array
     */
    function getPaginationData(mixed $data): array
    {
        $paginationData = [
            "previous" => $data->previousPageUrl(),
            "next" => $data->nextPageUrl(),
            "current_page" => $data->currentPage(),
            "per_page" => $data->perPage(),
            "total_pages" => $data->lastPage(),
            "count" => $data->count(),
            "total_records" => $data->total(),
        ];
        return $paginationData;
    }
}
