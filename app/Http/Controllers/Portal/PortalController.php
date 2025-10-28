<?php

namespace App\Http\Controllers\Portal;

use App\Enums\GeneralEnums;
use App\Http\Requests\Portal\CreateContactMessageRequest;
use App\Http\Resources\AboutUsPageResource;
use App\Http\Resources\HomePageResource;
use App\Http\Resources\NewsListResource;
use App\Http\Resources\ProjectListResource;
use App\Mail\ContactMessageMail;
use App\Models\AppSetting;
use App\Models\ContactMessage;
use App\Models\HomePageSection;
use App\Models\InfoPage;
use App\Models\PartnerAndSubsidiaries;
use App\Models\Project;
use App\Models\SEO;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                'project_id' => $request->project_id ?? null,
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
            $data['page_title'] = GeneralEnums::SEOPages[app()->getLocale() ?? 'ar']['projects'];
            $data['seo'] = SEO::where('page', 'projects')->first();
            $data['sections'] = Project::where('is_active', true)
                ->orderBy('order', 'ASC')
                ->whereNull('parent_id')
                ->get();

            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                ProjectListResource::make($data)
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
                "city_{$locale} as city",
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
                ->with(['units' => function ($query) use ($locale) {
                    $query->select(
                        'id',
                        'parent_id',
                        "name_{$locale} as name",
                        "description_{$locale} as description",
                        'lat',
                        'long',
                        'price',
                        'space_area',
                        'order',
                        "city_{$locale} as city",
                        'apartment_type as apartment_type_key',
                    )->orderBy('order', 'ASC')
                        ->where('is_active', true);
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

            // if (isset($record->apartment_type_key)) {
            //     $record['apartment_type_value'] = GeneralEnums::PropertyTypes[$locale][$record->apartment_type_key] ?? $record->apartment_type_key;
            // }

            // if (isset($record?->parent?->status_key)) {
            //     $record->parent['status_value'] = GeneralEnums::ProjectStatuses[$locale][$record->parent->status_key] ?? $record->parent->status_key;
            // }

            // if (isset($record?->parent?->apartment_type_key)) {
            //     $record->parent['apartment_type_value'] = GeneralEnums::PropertyTypes[$locale][$record->parent->apartment_type_key] ?? $record->parent->apartment_type_key;
            // }

            if (isset($record?->units) && $record->units->count() > 0) {
                foreach ($record->units as $child) {
                    // if (isset($child->status_key)) {
                    //     $child['status_value'] = GeneralEnums::ProjectStatuses[$locale][$child->status_key] ?? $child->status_key;
                    // }
                    if (isset($child->apartment_type_key)) {
                        $child['apartment_type_value'] = GeneralEnums::PropertyTypes[$locale][$child->apartment_type_key] ?? $child->apartment_type_key;
                    }
                }
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

    /**
     * Get About Us Page Info
     * @return \Illuminate\Http\JsonResponse
     */
    public function aboutUsPage()
    {
        try {
            $data['page_title'] = GeneralEnums::SEOPages[app()->getLocale() ?? 'ar']['about_us'];
            $data['seo'] = SEO::where('page', 'about_us')->first();
            $data['sections'] = InfoPage::orderBy('order', 'ASC')
                ->where('is_active', true)
                ->whereIn('type', ['mission', 'vision', 'values'])
                ->select(
                    'id',
                    'title_' . (app()->getLocale() ?? 'ar') . ' as title',
                    "description_" . (app()->getLocale() ?? 'ar') . " as description",
                    "type",
                    'order',
                )
                ->get()
                ->groupBy('type');

            $data['sections']['partners_and_subsidiaries'] = PartnerAndSubsidiaries::where('is_active', true)
                ->orderBy('order', 'ASC')
                ->select(
                    'id',
                    'name_' . (app()->getLocale() ?? 'ar') . ' as name',
                    "description_" . (app()->getLocale() ?? 'ar') . " as description",
                    "type",
                    'order',
                    'url',
                )
                ->get()
                ->groupBy('type');
            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                AboutUsPageResource::make($data)
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }


    /**
     * Get News List
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     */    public function newsList(Request $request)
    {
        try {
            $data['page_title'] = GeneralEnums::SEOPages[app()->getLocale() ?? 'ar']['news'];
            $data['seo'] = SEO::where('page', 'news')->first();
            $data['sections'] = InfoPage::orderBy('order', 'ASC')
                ->where('is_active', true)
                ->where('type', 'news')
                ->get();
            return apiResponse(
                true,
                '',
                Response::HTTP_OK,
                NewsListResource::make($data)
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }


    /**
     * Get News Details
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * 
     */    public function newsDetails($id)
    {
        try {
            $record = InfoPage::where('is_active', true)
                ->where('type', 'news')
                ->where('id', $id)
                ->select(
                    'id',
                    "title_" . (app()->getLocale() ?? 'ar') . " as title",
                    "description_" . (app()->getLocale() ?? 'ar') . " as description",
                    'order',
                )
                ->first();

            if (!$record) {
                return apiResponse(
                    true,
                    trans('messages.record_not_found'),
                    Response::HTTP_BAD_REQUEST
                );
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
}
