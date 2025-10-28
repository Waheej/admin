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
        'webp' => 'webp',
        'mp4' => 'mp4',
        'avi' => 'avi',
        'mov' => 'mov',
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
            // 'privacy_policy' => 'Privacy Policy',
            // 'terms_conditions' => 'Terms Conditions',
            // 'faq' => 'FAQ',
            // 'news' => 'News',
            'mission' => 'Our Mission',
            'vision' => 'Our Vision',
            'values' => 'Our Values',
        ],
        'ar' => [
            // 'privacy_policy' => 'سياسة الخصوصيه',
            // 'terms_conditions' => 'الشروط و الأحكام',
            // 'faq' => 'الاسئله المتكرره',
            // 'news' => 'الأخبار',
            'mission' => 'مهمتنا',
            'vision' => 'رؤيتنا',
            'values' => 'قيمنا',
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

    const PropertyTypes = [
        'en' => [
            'apartment' => 'Apartment',
            'villa' => 'Villa',
            'twinhouse' => 'Twinhouse',
            'townhouse' => 'Townhouse',
            'duplex' => 'Duplex',
            'penthouse' => 'Penthouse',
            'chalet' => 'Chalet',
            'studio' => 'Studio',
            'cabin' => 'Cabin',
            'clinic' => 'Clinic',
            'office' => 'Office',
            'retail' => 'Retail',
            'land' => 'Land',
        ],
        'ar' => [
            'apartment' => 'شقة',
            'villa' => 'فيلا',
            'twinhouse' => 'توين هاوس',
            'townhouse' => 'تاون هاوس',
            'duplex' => 'دوبلكس',
            'penthouse' => 'بنتهاوس',
            'chalet' => 'شاليه',
            'studio' => 'ستوديو',
            'cabin' => 'كابينة',
            'clinic' => 'عيادة',
            'office' => 'مكتب',
            'retail' => 'متجر',
            'land' => 'قطعة أرض',
        ],
    ];

    // Home page sections
    const HomePageSectionTypes = [
        'en' => [
            'hero' => 'Hero',
            'about_us' => 'About Us',
            'featured_projects' => 'Featured Projects',
            'partners' => 'Partners',
            'news' => 'News',
            'contact_us' => 'Contact Us',
        ],
        'ar' => [
            'hero' => 'الصفحه الرئيسيه',
            'about_us' => 'من نحن',
            'featured_projects' => 'مشاريع مميزة',
            'partners' => 'شركاء',
            'news' => 'الأخبار',
            'contact_us' => 'تواصل معنا',
        ],
    ];

    // SEO Pages
    const SEOPages = [
        'en' => [
            'home' => 'Home',
            'about_us' => 'About Us',
            'projects' => 'Projects',
            'news' => 'News',
        ],
        'ar' => [
            'home' => 'الرئيسية',
            'about_us' => 'من نحن',
            'projects' => 'المشاريع',
            'news' => 'الأخبار',
        ],
    ];
}
