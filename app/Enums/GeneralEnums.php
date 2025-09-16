<?php

namespace App\Enums;


/**
 * Class GeneralEnums
 *
 * This class defines file-related enumerations, such as file types and their corresponding icons.
 *
 * @package App\Enums
 */

enum GeneralEnums
{
    const ITEM_PER_PAGE = 10;

    // Files
    const FileTypes = [
        'pdf' => 'pdf',
        'jpeg' => 'jpeg',
        'jpg' => 'jpg',
        'png' => 'png',
        'gif' => 'gif',
        'svg' => 'svg',
        'doc' => 'doc',
        'docx' => 'docx',
        'xls' => 'xls',
        'xlsx' => 'xlsx',
        'ppt' => 'ppt',
        'pptx' => 'pptx',
        'txt' => 'txt',
    ];

    // Permissions
    const PermissionActions = [
        'en' => [
            'Index' => 'Index',
            'Show' => 'Show',
            'Create' => 'Create',
            'Edit' => 'Edit',
            'Destroy' => 'Destroy',
            'Toggleactivity' => 'Toggle Activity',
            'Permissions' => 'Edit Permissions',
            'Export' => 'Export',
            'Image' => 'Image',
        ],
        'ar' => [
            'Index' => 'عرض الكل',
            'Show' => 'عرض',
            'Create' => 'إنشاء',
            'Edit' => 'تعديل',
            'Destroy' => 'حذف',
            'Toggleactivity' => 'تبديل الحاله',
            'Permissions' => 'تعديل الصلاحيات',
            'Export' => 'تصدير',
            'Image' => 'صورة',
        ]
    ];

    // InfoPages
    const InfoPageTypes = [
        'en' => [
            'privacy_policy' => 'Privacy Policy',
            'terms_conditions' => 'Terms Conditions',
            'faq' => 'FAQ',
            'news' => 'News',
            'mission' => 'Our Mission',
            'vision' => 'Our Vision',
        ],
        'ar' => [
            'privacy_policy' => 'سياسة الخصوصيه',
            'terms_conditions' => 'الشروط و الأحكام',
            'faq' => 'الاسئله المتكرره',
            'news' => 'الأخبار',
            'mission' => 'مهمتنا',
            'vision' => 'رؤيتنا',
        ]
    ];

    // Contact Messages
    const ContactMessageTypes = [
        'en' => [
            'contact_us' => 'Contact Us',
            'complains' => 'Complains',
        ],
        'ar' => [
            'contact_us' => 'تواصل معنا',
            'complains' => 'الشكاوى',
        ]
    ];

    const ContactMessageStatuses = [
        'en' => [
            'in_progress' => 'In Progress',
            'opened' => 'Opened',
        ],
        'ar' => [
            'in_progress' => 'قيد المراجعه',
            'opened' => 'تم الفتح',
        ],
    ];

    // Project Status
    const ProjectStatuses = [
        'en' => [
            'upcoming' => 'Upcoming',
            'active' => 'Active',
            'completed' => 'Completed',
        ],
        'ar' => [
            'upcoming' => 'قادم',
            'active' => 'نشط',
            'completed' => 'مكتمل',
        ],
    ];

    // SubsidiaryTypes
    const SubsidiaryTypes = [
        'en' => [
            'subsidiary' => 'Subsidiary',
            'partner' => 'Partner'
        ],
        'ar' => [
           'subsidiary' => 'شركة تابعة',
            'partner' => 'شريك',
        ],
    ];

    // Property Sale Types
    const PropertySaleType = [
        'en' => [
            'developer_sale' => 'Developer Sale',
            'resale' => 'Resale',
        ],
        'ar' => [
            'developer_sale' => 'بيع من المطور',
            'resale' => 'إعادة بيع',
        ],
    ];

    const Currencies = [
        'en' => [
            'egp' => 'EGP',
            'usd' => 'USD',
        ],
        'ar' => [
            'egp' => 'جنيه مصرى',
            'usd' => 'دولار أمريكى',
        ],
    ];

    // Home page sections
    const HomePageSectionTypes = [
        'en' => [
            'hero' => 'Hero',
            'featured_projects' => 'Featured Projects',
            'news' => 'News',
            'map' => 'Map',
            'stats' => 'Stats',
            'testimonials' => 'Testimonials',
            'cta' => 'Call To Action',
            'newsletter' => 'Newsletter',
        ],
        'ar' => [
            'hero' => 'الرئيسية',
            'featured_projects' => 'مشاريع مميزة',
            'news' => 'الأخبار',
            'map' => 'الخريطة',
            'stats' => 'الإحصائيات',
            'testimonials' => 'الشهادات',
            'cta' => 'دعوة لاتخاذ إجراء',
            'newsletter' => 'النشرة الإخبارية',
        ],
    ];

}
