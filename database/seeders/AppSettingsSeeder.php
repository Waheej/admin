<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //    instagram, tiktok, snapchat , phone , X, youtube, linkedin
        AppSetting::firstOrCreate(
            [
                'key' => 'email'
            ],
            [
                'value' => 'info@waheej.com',
                'title_en' => 'Email',
                'title_ar' => 'البريد الإلكتروني',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'phone'
            ],
            [
                'value' => '+971 50 123 4567',
                'title_en' => 'Phone',
                'title_ar' => 'رقم الهاتف',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'address'
            ],
            [
                'value' => '1234 Street Name, City, Country',
                'title_en' => 'Address',
                'title_ar' => 'العنوان',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'instagram'
            ],
            [
                'value' => 'https://www.instagram.com/yourprofile',
                'title_en' => 'Instagram',
                'title_ar' => 'إنستجرام',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'tiktok'
            ],
            [
                'value' => 'https://www.tiktok.com/@yourprofile',
                'title_en' => 'TikTok',
                'title_ar' => 'تيك توك',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'snapchat'
            ],
            [
                'value' => 'https://www.snapchat.com/add/yourprofile',
                'title_en' => 'Snapchat',
                'title_ar' => 'سناب شات',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'x'
            ],
            [
                'value' => 'https://www.twitter.com/yourprofile',
                'title_en' => 'X',
                'title_ar' => 'إكس',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'youtube'
            ],
            [
                'value' => 'https://www.youtube.com/yourchannel',
                'title_en' => 'YouTube',
                'title_ar' => 'يوتيوب',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'key' => 'linkedin'
            ],
            [
                'value' => 'https://www.linkedin.com/in/yourprofile',
                'title_en' => 'LinkedIn',
                'title_ar' => 'لينكدإن',
            ]
        );
    }
}
