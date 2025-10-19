"use client";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import MediaCenterSection from "@/app/components/ui/mediaCenterSection/MediaCenterSection";
import { useTranslations } from "next-intl";
import React from "react";

const MediaCenterPage = () => {
    const t = useTranslations();
    return (
        <>
            <GeneralBanner title={t("pages.media_center_title")} imageSrc="/images/media-center.png" />
            <MediaCenterSection />
        </>
    );
};

export default MediaCenterPage;
