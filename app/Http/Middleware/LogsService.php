<?php

namespace App\Http\Middleware;

use App\Jobs\SendLogJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogsService
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (($request->method() == "GET" && !str_contains($request->route()->getName(), 'export')) || $request->route()->getName() == "streamFile" || $request->route()->getName() == "export_errors") {
            return $next($request);
        }
        // Collect data from original request
        $obj["route_name"] = $request->route()->getName(); // Ex: tenant.internal_user.customer.individuals.update (tenant.[user_type].[module].[model].[action])
        $obj["url"] = $request->url();
        $obj["method"] = $request->method();
        $obj["ip"] = $request->ip();
        $obj["user_id"] = auth()->guard('web')->check() ? auth('web')->user()->id : null;
        $obj["user_agent"] = $request->userAgent();

        $obj["request_body"] = $request->all();

        // not used in the current response
        if ((isset($request['files'])) && (str_contains($obj["route_name"], 'attach_files')) && ($request->hasFile('files'))) {
            $files = [];
            foreach ($request['files'] as $key => $file) {
                if (is_object($file) && get_class($file) == 'Illuminate\Http\UploadedFile') {
                    $files[$key] = substr($file->getClientOriginalName(), 0, 100);
                }
            }
            $obj["request_body"] = $files;
        }


        if (isset($obj["request_body"]["password"])) {
            unset($obj["request_body"]["password"]);
        }

        if (isset($obj["request_body"]["password_confirmation"])) {
            unset($obj["request_body"]["password_confirmation"]);
        }

        if (isset($obj["request_body"]["new_password"])) {
            unset($obj["request_body"]["new_password"]);
        }

        if (isset($obj["request_body"]["new_password_confirmation"])) {
            unset($obj["request_body"]["new_password_confirmation"]);
        }

        if (isset($obj["request_body"]["html"])) {
            unset($obj["request_body"]["html"]);
        }

        // Get the response from the next middleware in the chain
        $response = $next($request);
        // Get the content of the response (the JSON data)
        $content = $response->getContent();

        // Decode the JSON data into an associative array
        $data = json_decode($content, true);
        $modelsMap = ModelsMap();
        if (Str::studly(Str::singular(explode(".", $obj["route_name"])[1]) == 'log') && explode(".", $obj["route_name"])[2] == 'restore') {
            $obj["model"] = $request->model;
        } else {
            $obj["model"] = isset($modelsMap[Str::studly(Str::singular(explode(".", $obj["route_name"])[1]))]) ? $modelsMap[Str::studly(Str::singular(explode(".", $obj["route_name"])[1]))] : 'Log';
        }
        $obj["model_id"] = isset($data["data"][Str::singular(explode(".", $obj["route_name"])[1])]) && isset($data["data"][Str::singular(explode(".", $obj["route_name"])[1])]['id'])
            ? $data["data"][Str::singular(explode(".", $obj["route_name"])[1])]['id']
            : null;

        if (str_contains($obj["route_name"], 'attach_files')) {
            $obj["model_id"] = request()->route('id');
        }

        $obj['response'] = $data;

        if (isset($data["data"]["old_data"])) {
            // Collect original data from response (old_data)
            $obj["old_data"] = $data["data"]["old_data"];

            // Collect modified data from response (new_data)
            // for each key in old data, check if in request body
            // if yes, check if value is different
            // if no, remove from old data
            foreach ($obj["old_data"] as $key => $value) {
                if (isset($obj["request_body"][$key])) {
                    if ($obj["request_body"][$key] == $value) {
                        unset($obj["old_data"][$key]);
                    }
                } else {
                    unset($obj["old_data"][$key]);
                }
            }
            //
            // Remove old_data from response
            unset($data["data"]["old_data"]);

            // Encode the modified data back to JSON
            $content = json_encode($data);

            // Update the response content with the modified JSON
            $response->setContent($content);
        }

        if ($response->status() < 400) {
            $obj["model_id"] = isset($data["data"][Str::singular(explode(".", $obj["route_name"])[1])]) && isset($data["data"][Str::singular(explode(".", $obj["route_name"])[1])]['id'])
                ? $data["data"][Str::singular(explode(".", $obj["route_name"])[1])]['id']
                : null;

            if (str_contains($obj["route_name"], 'attach_files')) {
                $obj["model_id"] = request()->route('id');
            }

            if (str_contains($obj["route_name"], 'destroy')) {
                $modelId = explode('/', $obj["url"]);
                $obj["model_id"] = end($modelId);
            }

            $obj["status"] = true;
        }

        if ($response->status() >= 400) {
            $obj["status"] = false;
        }

        $obj["status_code"] = $response->status();
        //Send Object to Log Service (Call Log service API)
        foreach ($obj["request_body"] as $key => $value) {
            // check if $value is UploadedFile
            if (is_object($value) && get_class($value) == 'Illuminate\Http\UploadedFile') {
                $obj["request_body"][$key] = substr($value->getClientOriginalName(), 0, 100);
            }

            if ($key == 'file' && str_contains($request->route()->getName(), 'import')) {
                $obj["request_body"][$key] = "Import File";
            }
        }

        dispatch(new SendLogJob($obj));

        return $response;
    }
}
