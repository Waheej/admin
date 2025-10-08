<?php

namespace App\Http\Controllers\Portal;

use App\Enums\GeneralEnums;
use App\Http\Requests\Portal\CreateContactMessageRequest;
use App\Http\Resources\HomePageResource;
use App\Mail\ContactMessageMail;
use App\Models\AppSetting;
use App\Models\ContactMessage;
use App\Models\HomePageSection;
use App\Models\Project;
use App\Models\SEO;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PortalController
{

    /**
     * Create a New ContactMessage Record
     * @param CreateContactMessageRequest $request
     */

    public function createContactMessage(CreateContactMessageRequest $request)
    {
        try {
            ContactMessage::create([
                'name' => $request->name,
                'country_code' => $request->country_code,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'message' => $request->message,
                'project_id' => $request->project_id,
                'status' => 'in_progress'
            ]);

            // send email to admin
            // Mail::to(env('ADMIN_EMAIL'))->send(new ContactMessageMail($request->validated()));

            return apiResponse(
                true,
                trans('messages.created_successfully'),
                Response::HTTP_OK,
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * Get Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo()
    {
        try {
            $locale = app()->getLocale() ?? 'ar';
            $records = AppSetting::select('id', 'key', 'value', "title_{$locale} as title")
                ->where('is_active', true)
                ->get();

            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                $records
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * Get Projects List
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectsList()
    {
        try {
            $locale = app()->getLocale() ?? 'ar';
            $records = Project::select(
                'id',
                "name_{$locale} as name",
                "description_{$locale} as description",
                'city',
                'apartment_type',
                'price',
            )
                ->where('is_active', true)
                ->orderBy('order', 'ASC')
                ->get();
            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                $records
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * Get Project Details
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectDetails($id)
    {
        try {
            $locale = app()->getLocale() ?? 'ar';
            $record = Project::select(
                'id',
                "name_{$locale} as name",
                "description_{$locale} as description",
                'lat',
                'long',
                'price',
                'city',
                'apartment_type',
                'parent_id',
                'status as status_key'
            )
                ->where('is_active', true)
                ->where('id', $id)
                ->with(['news' => function ($query) use ($locale) {
                    $query->select(
                        'id',
                        'project_id',
                        "title_{$locale} as title",
                        "description_{$locale} as description",
                    );
                }])
                ->with(['parent' => function ($query) use ($locale) {
                    $query->select(
                        'id',
                        "name_{$locale} as name",
                    );
                }])
               ->with(['children' => function ($query) use ($locale) {
                    $query->select(
                        'id',
                        'parent_id',
                        "name_{$locale} as name"
                    );
                }])
                ->first();

            if (!$record) {
                return apiResponse(
                    true,
                    trans('messages.record_not_found'),
                    Response::HTTP_BAD_REQUEST
                );
            }

            if (isset($record->status_key)) {
                $record['status_value'] = GeneralEnums::ProjectStatuses[$locale][$record->status_key] ?? $record->status_key;
            }

            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                $record
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

    /**
     * Get Home Page Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function homePage()
    {
        try {
            $data['page_title'] = GeneralEnums::SEOPages[app()->getLocale() ?? 'ar']['home'];
            $data['seo'] = SEO::where('page', 'home')->first();
            $data['sections'] = HomePageSection::orderBy('order', 'ASC')
                ->where('is_active', true)
                ->get();
            // dd($data);
            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                HomePageResource::make($data)
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }
}
