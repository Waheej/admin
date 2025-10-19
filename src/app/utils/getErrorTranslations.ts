import arTranslations from '../../../messages/ar.json';
import enTranslations from '../../../messages/en.json';

export function getErrorTranslations(lang: 'ar' | 'en') {
  const translations = lang === 'ar' ? arTranslations : enTranslations;
  
  return translations.error || {
    page_title: lang === 'ar' ? 'عذراً، حدث خطأ' : 'Oops, Something Went Wrong',
    page_description: lang === 'ar'
      ? 'نعتذر عن الإزعاج. حدث خطأ غير متوقع أثناء تحميل هذه الصفحة.'
      : 'We apologize for the inconvenience. An unexpected error occurred while loading this page.',
    try_again: lang === 'ar' ? 'حاول مرة أخرى' : 'Try Again',
    back_home: lang === 'ar' ? 'العودة للرئيسية' : 'Back to Home',
    not_found_title: lang === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found',
    not_found_description: lang === 'ar'
      ? 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.'
      : 'Sorry, the page you are looking for does not exist or has been moved.',
    view_projects: lang === 'ar' ? 'المشاريع' : 'View Projects',
  };
}

