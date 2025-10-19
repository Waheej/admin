'use client';

import { useRouter, usePathname } from 'next/navigation';
import { useEffect, useMemo, useState } from 'react';
import Image from 'next/image';
import { getErrorTranslations } from '@/app/utils/getErrorTranslations';

export default function Error({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  const router = useRouter();
  const pathname = usePathname();
  const [mounted, setMounted] = useState(false);
  
  // ✅ Detect language from pathname
  const lang = useMemo(() => {
    return pathname?.startsWith('/ar') ? 'ar' : 'en';
  }, [pathname]);

  // ✅ Get translations from utility function
  const translations = getErrorTranslations(lang);

  useEffect(() => {
    setMounted(true);
  }, [error]);

  return (
    <div className="min-h-screen flex items-center justify-center p-4" style={{ backgroundColor: '#F2EEE2' }}>
      <div className="container mx-auto px-4">
        <div className={`text-center max-w-2xl mx-auto space-y-8 transition-all duration-700 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
          {/* Logo */}
          <div className={`mb-12 transition-all duration-500 delay-100 ${mounted ? 'opacity-100 scale-100' : 'opacity-0 scale-90'}`}>
            <div className="relative w-48 h-20 mx-auto">
              <Image
                src="/images/logo/logo-rect-dark.svg"
                alt="Waheej Logo"
                fill
                className="object-contain"
                priority
              />
            </div>
          </div>

          {/* Error Icon */}
          <div 
            className={`w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-8 transition-all duration-700 delay-200 ${mounted ? 'opacity-100 scale-100' : 'opacity-0 scale-75'}`}
            style={{ backgroundColor: '#fee2e2' }}
          >
            <svg
              className="w-16 h-16 animate-pulse"
              style={{ color: '#dc2626' }}
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              />
            </svg>
          </div>

          {/* Error Message */}
          <div className={`space-y-4 transition-all duration-700 delay-300 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'}`}>
            <h1 className="text-4xl font-bold uppercase" style={{ color: '#131817' }}>
              {translations.page_title}
            </h1>
            <p className="text-lg max-w-md mx-auto leading-relaxed" style={{ color: 'rgba(19, 24, 23, 0.7)' }}>
              {translations.page_description}
            </p>
          </div>

          {/* Error Details (only in development) */}
          {process.env.NODE_ENV === 'development' && error.message && (
            <div 
              className={`p-6 rounded-2xl text-left border transition-all duration-700 delay-400 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'}`}
              style={{ backgroundColor: 'rgba(245, 245, 245, 0.3)', borderColor: 'rgba(19, 24, 23, 0.1)' }}
            >
              <p className="text-xs uppercase mb-2" style={{ color: 'rgba(19, 24, 23, 0.5)' }}>
                Error Details:
              </p>
              <p className="text-sm font-mono break-words" style={{ color: 'rgba(19, 24, 23, 0.8)' }}>
                {error.message}
              </p>
            </div>
          )}

          {/* Actions */}
          <div className={`flex items-center justify-center gap-4 pt-8 flex-wrap transition-all duration-700 delay-500 ${mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'}`}>
            <button
              onClick={reset}
              className="px-8 py-3 rounded-full font-medium uppercase transition-all hover:scale-105 hover:shadow-lg active:scale-95"
              style={{ backgroundColor: '#131817', color: 'white' }}
            >
              {translations.try_again}
            </button>
            <button
              onClick={() => router.push(`/${lang}`)}
              className="px-8 py-3 rounded-full font-medium uppercase transition-all hover:scale-105 hover:shadow-lg active:scale-95 border-2"
              style={{ borderColor: '#131817', color: '#131817', backgroundColor: 'white' }}
            >
              {translations.back_home}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

