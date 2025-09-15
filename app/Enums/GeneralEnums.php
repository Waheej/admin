<?php

namespace App\Enums;

use App\Models\Area;
use App\Models\Compound;
use App\Models\Property;

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

    // finishing types
    const FinishingTypes = [
        'en' => [
            'fully_finished' => 'Fully Finished',
            'semi_finished' => 'Semi Finished',
            'without_finished' => 'Without Finished',
            'furnished' => 'Furnished',
        ],
        'ar' => [
            'fully_finished' => 'تشطيب كامل',
            'semi_finished' => 'نصف تشطيب',
            'without_finished' => 'بدون تشطيب',
            'furnished' => 'مفروش',
        ],
    ];

    const PropertyTypes = [
        'en' => [
            'apartment' => [
                'title' => 'Apartment',
                'logo' => 'apartment.svg',
            ],
            'villa' => [
                'title' => 'Villa',
                'logo' => 'villa.svg',
            ],
            'twinhouse' => [
                'title' => 'Twinhouse',
                'logo' => 'twinhouse.svg',
            ],
            'townhouse' => [
                'title' => 'Townhouse',
                'logo' => 'townhouse.svg',
            ],
            'duplex' => [
                'title' => 'Duplex',
                'logo' => 'duplex.svg',
            ],
            'penthouse' => [
                'title' => 'Penthouse',
                'logo' => 'penthouse.svg',
            ],
            'chalet' => [
                'title' => 'Chalet',
                'logo' => 'chalet.svg',
            ],
            'studio' => [
                'title' => 'Studio',
                'logo' => 'studio.svg',
            ],
            'cabin' => [
                'title' => 'Cabin',
                'logo' => 'cabin.svg',
            ],
            'clinic' => [
                'title' => 'Clinic',
                'logo' => 'clinic.svg',
            ],
            'office' => [
                'title' => 'Office',
                'logo' => 'office.svg',
            ],
            'retail' => [
                'title' => 'Retail',
                'logo' => 'retail.svg',
            ],
        ],
        'ar' => [
            'apartment' => [
                'title' => 'شقة',
                'logo' => 'apartment.svg',
            ],
            'villa' => [
                'title' => 'فيلا',
                'logo' => 'villa.svg',
            ],
            'twinhouse' => [
                'title' => 'توين هاوس',
                'logo' => 'twinhouse.svg',
            ],
            'townhouse' => [
                'title' => 'تاون هاوس',
                'logo' => 'townhouse.svg',
            ],
            'duplex' => [
                'title' => 'دوبلكس',
                'logo' => 'duplex.svg',
            ],
            'penthouse' => [
                'title' => 'بنتهاوس',
                'logo' => 'penthouse.svg',
            ],
            'chalet' => [
                'title' => 'شاليه',
                'logo' => 'chalet.svg',
            ],
            'studio' => [
                'title' => 'ستوديو',
                'logo' => 'studio.svg',
            ],
            'cabin' => [
                'title' => 'كابينة',
                'logo' => 'cabin.svg',
            ],
            'clinic' => [
                'title' => 'عيادة',
                'logo' => 'clinic.svg',
            ],
            'office' => [
                'title' => 'مكتب',
                'logo' => 'office.svg',
            ],
            'retail' => [
                'title' => 'متجر',
                'logo' => 'retail.svg',
            ],
        ],
    ];

    const LogActionsMap = [
        'en' => [
            'GET' => 'Viewed',
            'POST' => 'Created',
            'PUT' => 'Updated',
            'DELETE' => 'Deleted',
            'LOGIN' => 'Logged in',
            'ATTACH' => 'Attached files',
            'EXPORT' => 'Exported',
            'IMPORT' => 'Imported',
        ],
        'ar' => [
            'GET' => 'تم عرض',
            'POST' => 'تم إنشاء',
            'PUT' => 'تم تعديل',
            'DELETE' => 'تم حذف',
            'LOGIN' => 'تسجيل دخول',
            'ATTACH' => 'تم ارفاق ملفات',
            'EXPORT' => 'تم تصدير',
            'IMPORT' => 'تم استيراد',
        ]
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

}
