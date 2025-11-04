"use client";

import { useRouter, usePathname } from "next/navigation";
import { useEffect, useMemo, useState } from "react";
import Image from "next/image";
import { getErrorTranslations } from "@/app/utils/getErrorTranslations";
import useNotFoundPage from "@/app/store/useNotFoundPage";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";

export default function Error({ error, reset }: { error: Error & { digest?: string }; reset: () => void }) {
    const router = useRouter();
    const pathname = usePathname();
    const [mounted, setMounted] = useState(false);
    const { setIsErrorPage } = useNotFoundPage();

    // ✅ Detect language from pathname
    const lang = useMemo(() => {
        return pathname?.startsWith("/ar") ? "ar" : "en";
    }, [pathname]);

    // ✅ Get translations from utility function
    const translations = getErrorTranslations(lang);

    useEffect(() => {
        setMounted(true);
        setIsErrorPage(true);

        return () => {
            setIsErrorPage(false);
        };
    }, [error, setIsErrorPage]);

    return (
        <div className="min-h-screen flex items-center justify-center p-4 rounded-3xl" style={{ backgroundColor: "#F2EEE2" }}>
            <div className="container mx-auto px-4">
                <div className={`text-center max-w-2xl mx-auto space-y-8`}>
                    {/* Error Message */}
                    <div className={`space-y-4 `}>
                        <h1 className="text-4xl font-bold uppercase" style={{ color: "#131817" }}>
                            {translations.page_title}
                        </h1>
                        <p className="text-lg max-w-md mx-auto leading-relaxed" style={{ color: "rgba(19, 24, 23, 0.7)" }}>
                            {translations.page_description}
                        </p>
                    </div>

                    {/* Error Details (only in development) */}
                    {/* {process.env.NODE_ENV === 'development' && error.message && (
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
          )} */}

                    {/* Actions */}
                    <div className={`flex items-center justify-center gap-4 pt-2 flex-wrap `}>
                        <GeneralButton title={translations.try_again} isBlack isPillEffect customClick={reset} />
                        <GeneralButton title={translations.back_home} isWhite isPillEffect customClick={() => router.push(`/`)} />
                    </div>
                </div>
            </div>
        </div>
    );
}
