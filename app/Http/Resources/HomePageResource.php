<?php

namespace App\Http\Resources;

use App\Enums\GeneralEnums;
use App\Models\InfoPage;
use App\Models\PartnerAndSubsidiaries;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class HomePageResource extends JsonResource
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
                'title' => $this['seo']->{"title_" . $locale} ?? $this['seo']->title_ar,
                'description' => $this['seo']->{"description_" . $locale} ?? $this['seo']->description_ar,
                'url' => $this['seo']->url,
                'keywords' => $this['seo']->{"keywords_" . $locale} ?? $this['seo']->keywords_ar,
                'og' => [
                    'title' => $this['seo']->{"og_title_" . $locale} ?? $this['seo']->og_title_ar,
                    'description' => $this['seo']->{"og_description_" . $locale} ?? $this['seo']->og_description_ar,
                    'url' => $this['seo']->og_url,
                    'image' => $this['seo']->og_image,
                ],
                'twitter' => [
                    'title' => $this['seo']->{"twitter_title_" . $locale} ?? $this['seo']->twitter_title_ar,
                    'description' => $this['seo']->{"twitter_description_" . $locale} ?? $this['seo']->twitter_description_ar,
                    'url' => $this['seo']->twitter_url,
                    'image' => $this['seo']->twitter_image,
                ],
                'canonical_url' => $this['seo']->canonical_url,
                'robots' => $this['seo']->robots,
            ],
            'sections' => $this['sections']->map(function ($section) use ($locale) {
                if ($section->type == 'featured_projects') {
                    $section['data'] = Project::select('id', "name_{$locale} as name", "description_{$locale} as description")
                        ->where('is_active', true)
                        ->orderBy('order', 'ASC')
                        ->get();
                }

                if ($section->type == 'news') {
                    $section['data'] = InfoPage::where('type', 'news')
                        ->where('is_active', true)
                        ->select(
                            'id',
                            "title_{$locale} as title",
                            "description_{$locale} as description",
                            'order',
                            'project_id',
                        )
                        ->orderBy('order', 'ASC')
                        ->get();
                }

                if ($section->type == 'partners') {
                  $section['data'] = PartnerAndSubsidiaries::where('type', 'partner')
                        ->where('is_active', true)
                        ->select(
                            'id',
                            "name_{$locale} as name",
                            "description_{$locale} as description",
                            'order',
                        )
                        ->orderBy('order', 'ASC')
                        ->get();
                }

                return [
                    'id' => $section->id,
                    'title' => $section->{"title_" . $locale} ?? $section->title_ar,
                    'description' => $section->{"description_" . $locale} ?? $section->description_ar,
                    'type_key' => $section->type,
                    'type_value' => GeneralEnums::HomePageSectionTypes[$locale][$section->type] ?? null,
                    'order' => $section->order,
                    'media' => $section->media,
                    'mobile_media' => $section->mobile_media,
                    'videos' => $section->videos,
                    'data' => $section->data ?? [],
                ];
            })
        ];
    }
}
