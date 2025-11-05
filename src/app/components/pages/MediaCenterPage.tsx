"use client";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import MediaCenterSection from "@/app/components/ui/mediaCenterSection/MediaCenterSection";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React from "react";

const MediaCenterPage = () => {
    const t = useTranslations();
    const userLang = useLocale();
    const { data, isLoading, isError } = useQuery({
        queryKey: ["newsList", userLang],
        queryFn: () => handleFetchRequest("newsList", "GET", null, userLang),
        retry: 2,
    });
    return (
        <>
            <GeneralBanner title={t("pages.media_center_title")} imageSrc="/images/media_center.png" />
            <MediaCenterSection data={data?.data?.sections} />
        </>
    );
};

export default MediaCenterPage;
