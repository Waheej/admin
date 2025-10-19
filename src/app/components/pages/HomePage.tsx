"use client";

import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import AboutSection from "@/app/components/ui/aboutSection/AboutSection";
import ContactSection from "@/app/components/ui/contactSection/ContactSection";
import FeaturedProjects from "@/app/components/ui/featuredProjects/FeaturedProjects";
import NewsSection from "@/app/components/ui/newsSection/NewsSection";
import PartnerSection from "@/app/components/ui/partnerSection/PartnerSection";
import { useInitialLoader } from "@/app/store/useInitialLoader";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React, { Fragment, useEffect } from "react";

const HomePage = () => {
    const t = useTranslations();
    const userLang = useLocale();
    const { hide: hideInitialLoader, setProgress } = useInitialLoader();
    
    const { data, isLoading, isError, error } = useQuery({
        queryKey: ["homePage", userLang],
        queryFn: async () => {
            try {
                const res = await handleFetchRequest("homePage", "GET", null, userLang);
                return res || {};
            } catch (err) {
                throw err;
            }
        },
        staleTime: 1000 * 60 * 5,
        retry: 2,
    });

    useEffect(() => {
        if (isLoading) {
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                if (progress <= 90) {
                    setProgress(progress);
                } else {
                    clearInterval(interval);
                }
            }, 100);

            return () => clearInterval(interval);
        } else if (data || isError) {
            setProgress(100);
            setTimeout(() => hideInitialLoader(), 500);
        }
    }, [isLoading, data, isError, setProgress, hideInitialLoader]);

    // Error state
    if (isError) {
        return (
            <div className="min-h-screen flex items-center justify-center p-4">
                <div className="text-center max-w-md">
                    <h2 className="text-2xl font-bold mb-4">فشل تحميل البيانات</h2>
                    <p className="text-dark/60 mb-6">
                        {(error as any)?.message || "حدث خطأ أثناء تحميل الصفحة"}
                    </p>
                    <button
                        onClick={() => window.location.reload()}
                        className="px-6 py-3 bg-black text-white rounded-lg hover:bg-black/90 transition"
                    >
                        إعادة المحاولة
                    </button>
                </div>
            </div>
        );
    }
    
    return (
        <Fragment>
            <GeneralBanner
                enquiry_btn={t("common.enquiry_now")}
                isDownloadBorochure
                title={data?.data?.sections?.[0]?.title}
                description={data?.data?.sections?.[0]?.description}
                // isVideo
                imageSrc={data?.data?.sections?.[0]?.media?.[0]}
                // videoSrc="/videos/video.mp4"
                // VideoPopupSrc="/videos/video.mp4"
            />
            <AboutSection data={data?.data?.sections?.[1] } />
            <FeaturedProjects data={data?.data?.sections?.[2]} />
            <PartnerSection data={data?.data?.sections?.[3]} />
            <NewsSection data={data?.data?.sections?.[4]} />
            <ContactSection data={data?.data?.sections?.[5]} />
        </Fragment>
    );
};

export default HomePage;
