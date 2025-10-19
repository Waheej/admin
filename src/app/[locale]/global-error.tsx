'use client';

export default function GlobalError({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  // Detect language from URL
  const lang = typeof window !== 'undefined' && window.location.pathname.startsWith('/ar') ? 'ar' : 'en';
  
  const translations = {
    ar: {
      title: 'خطأ في التطبيق',
      description: 'حدث خطأ غير متوقع. يرجى تحديث الصفحة أو المحاولة لاحقاً.',
      tryAgain: 'حاول مرة أخرى',
      backHome: 'العودة للرئيسية',
    },
    en: {
      title: 'Application Error',
      description: 'An unexpected error occurred. Please refresh the page or try again later.',
      tryAgain: 'Try Again',
      backHome: 'Back to Home',
    },
  };

  const t = translations[lang];

  return (
    <html lang={lang} dir={lang === 'ar' ? 'rtl' : 'ltr'}>
      <body>
        <div className="min-h-screen flex items-center justify-center p-4 bg-white">
          <div className="text-center max-w-xl space-y-6">
            <div className="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto">
              <svg
                className="w-16 h-16 text-red-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </div>

            <h1 className="text-4xl font-bold uppercase">{t.title}</h1>
            <p className="text-lg text-gray-600">
              {t.description}
            </p>

            {/* Error details in development */}
            {process.env.NODE_ENV === 'development' && error?.message && (
              <div className="bg-gray-100 p-4 rounded-lg text-left">
                <p className="text-xs uppercase text-gray-500 mb-2">Error Details:</p>
                <p className="text-sm font-mono text-gray-800 break-words">
                  {error.message}
                </p>
              </div>
            )}

            <div className="flex justify-center gap-4 flex-wrap">
              <button
                onClick={reset}
                className="px-6 py-3 bg-black text-white rounded-full hover:bg-black/90 transition"
              >
                {t.tryAgain}
              </button>
              <button
                onClick={() => window.location.href = `/${lang}`}
                className="px-6 py-3 border-2 border-black text-black rounded-full hover:bg-black hover:text-white transition"
              >
                {t.backHome}
              </button>
            </div>
          </div>
        </div>
      </body>
    </html>
  );
}

