<?php

namespace App\Http\Resources;

use App\Enums\GeneralEnums;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale() ?? 'ar';
        return [
            'page_title' => $this['page_title'] ?? null,
            'seo' => [
                'title' => $this['seo']->{"title_" . $locale} ?? null,
                'description' => $this['seo']->{"description_" . $locale} ?? null,
                'url' => $this['seo']->url ?? null,
                'keywords' => $this['seo']->{"keywords_" . $locale} ?? null,
                'og' => [
                    'title' => $this['seo']->{"og_title_" . $locale} ?? null,
                    'description' => $this['seo']->{"og_description_" . $locale} ?? null,
                    'url' => $this['seo']->og_url ?? null,
                    'image' => $this['seo']->og_image ?? null,
                ],
                'twitter' => [
                    'title' => $this['seo']->{"twitter_title_" . $locale} ?? null,
                    'description' => $this['seo']->{"twitter_description_" . $locale} ?? null,
                    'url' => $this['seo']->twitter_url ?? null,
                    'image' => $this['seo']->twitter_image ?? null,
                ],
                'canonical_url' => $this['seo']->canonical_url ?? null,
                'robots' => $this['seo']->robots ?? null,
            ],
            'sections' => $this['sections']->map(function ($section) use ($locale) {
                return [
                    'id' => $section->id,
                    'name' => $section->{"name_" . $locale} ?? $section->name_ar,
                    'description' => $section->{"description_" . $locale} ?? $section->description_ar,
                    'lat' => $section->lat,
                    'long' => $section->long,
                    'price' => $section->price,
                    'city' => $section->{"city_" . $locale} ?? null,
                    'apartment_type_key' => $section->apartment_type,
                    'apartment_type_value' => $section->apartment_type ? GeneralEnums::PropertyTypes[$locale][$section->apartment_type] : null,
                    'status_key' => $section->status,
                    'status_value' => $section->status ? GeneralEnums::ProjectStatuses[$locale][$section->status] : null,
                    'parent_id' => $section->parent_id ?? null,
                    'map' => $section->map ?? null,
                    'image' => $section->image ?? null,
                    'image_mobile' => $section->image_mobile ?? null,
                    'video' => $section->video ?? null,
                    'rendered_images' => $section->rendered_images ?? [],
                    'rendered_images_mobile' => $section->rendered_images_mobile ?? [],
                ];
            }),
        ];
    }
}
