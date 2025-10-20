<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsListResource extends JsonResource
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
                    'title' => $section->{"title_" . $locale} ?? null,
                    'description' => $section->{"description_" . $locale} ?? null,
                    'media_path' => $section->media_path ?? null,
                    'mobile_media_path' => $section->mobile_media_path  ?? null,
                    'order' => $section->order ?? null,
                    'created_at' => $section->created_at->translatedFormat('d M, Y') ?? null,
                ];
            }),
        ];
    }
}
