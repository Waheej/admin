"use client";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import NewsSection from "@/app/components/ui/newsSection/NewsSection";
import ProjectMap from "@/app/components/ui/projectMap/ProjectMap";
import ProjectUnitsSection from "@/app/components/ui/projectUnitsSection/ProjectUnitsSection";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React from "react";

const SingleProjectPage = ({ slug }: { slug: string }) => {
    const userLang = useLocale();
    const t = useTranslations();
    const { data, isLoading, isError } = useQuery({
        queryKey: ["project", slug, userLang],
        queryFn: () => handleFetchRequest(`/projectDetails/${slug}`, "GET", null, userLang),
        retry: 2,
    });

    // ✅ Loading state
    if (isLoading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                    <p className="text-dark/60">جاري تحميل تفاصيل المشروع...</p>
                </div>
            </div>
        );
    }

    // ✅ Error state
    if (isError || !data?.data) {
        return (
            <div className="min-h-screen flex items-center justify-center p-4">
                <div className="text-center max-w-md">
                    <h2 className="text-2xl font-bold mb-4">المشروع غير موجود</h2>
                    <p className="text-dark/60 mb-6">
                        عذراً، لم نتمكن من العثور على هذا المشروع.
                    </p>
                    <button
                        onClick={() => window.location.href = '/projects'}
                        className="px-6 py-3 bg-black text-white rounded-lg hover:bg-black/90 transition"
                    >
                        العودة للمشاريع
                    </button>
                </div>
            </div>
        );
    }

    return (
        <>
            <GeneralBanner
                title={data?.data?.name}
                description={data?.data?.description}
                imageSrc="/images/banner.png"
                enquiry_btn={t("common.enquiry_now")}
                // projectLogo="/images/logo/logo-rect-light.svg"
                download_btn={t("pages.download_brochure")}
                isDownloadBorochure
            />
            <ProjectUnitsSection projects={data?.data?.units} />
            <ProjectMap projects={data?.data?.children} />
            {data?.data?.news && data?.data?.news.length > 0 && (
                <NewsSection data={data?.data?.news} isProjectNews={true} />
            )}
        </>
    );
};

export default SingleProjectPage;
