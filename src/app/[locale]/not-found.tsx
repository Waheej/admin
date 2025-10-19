'use client';

import { usePathname, useRouter } from 'next/navigation';
import { useMemo, useEffect, useState } from 'react';
import Image from 'next/image';
import { getErrorTranslations } from '@/app/utils/getErrorTranslations';
import useNotFoundPage from '@/app/store/useNotFoundPage';
import GeneralButton from '@/app/components/common/generalButton/GeneralButton';

export default function NotFound() {
  const pathname = usePathname();
  const router = useRouter();
  const [mounted, setMounted] = useState(false);
  const { setIsNotFoundPage } = useNotFoundPage();
  
  // ✅ Detect language from pathname
  const lang = useMemo(() => {
    return pathname?.startsWith('/ar') ? 'ar' : 'en';
  }, [pathname]);

  // ✅ Get translations from utility function
  const translations = getErrorTranslations(lang);

  useEffect(() => {
    setMounted(true);
    // ✅ نعلّم إننا في not-found page
    setIsNotFoundPage(true);
    
    // ✅ لما نخرج من الصفحة، نرجع للـ default
    return () => {
      setIsNotFoundPage(false);
    };
  }, [setIsNotFoundPage]);

  return (
    <div className="min-h-screen flex items-center justify-center p-4 bg-gray rounded-3xl">
      <div className="container mx-auto px-4">
        <div className={`text-center max-w-3xl mx-auto space-y-8 transition-all duration-700 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>

          {/* Message */}
          <div className={`space-y-4 transition-all duration-700 delay-400 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'}`}>
            <h2 className="text-4xl font-bold uppercase" style={{ color: '#131817' }}>
              {translations.not_found_title}
            </h2>
            <p className="text-lg max-w-md mx-auto leading-relaxed" style={{ color: 'rgba(19, 24, 23, 0.7)' }}>
              {translations.not_found_description}
            </p>
          </div>

          {/* Actions */}
          <div className={`flex items-center justify-center gap-4 pt-8 flex-wrap transition-all duration-700 delay-500 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'}`}>
 
            <GeneralButton
              title={translations.back_home}
              isBlack
              isPillEffect
              url={`/`}
            />
            <GeneralButton
              title={translations.view_projects}
              isWhite
              isPillEffect
              url={`/projects`}
            />
 
          </div>
        </div>
      </div>
    </div>
  );
}

