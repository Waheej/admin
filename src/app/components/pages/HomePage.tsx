"use client";

import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import AboutSection from "@/app/components/ui/aboutSection/AboutSection";
import ContactSection from "@/app/components/ui/contactSection/ContactSection";
import FeaturedProjects from "@/app/components/ui/featuredProjects/FeaturedProjects";
import NewsSection from "@/app/components/ui/newsSection/NewsSection";
import PartnerSection from "@/app/components/ui/partnerSection/PartnerSection";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React, { Fragment } from "react";

const HomePage = () => {
    const t = useTranslations();
    const userLang = useLocale();
    
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


    
    return (
        <Fragment>
            <GeneralBanner
                enquiry_btn={t("common.enquiry_now")}
                isDownloadBorochure
                title={data?.data?.sections?.[0]?.title}
                description={data?.data?.sections?.[0]?.description}
                isVideo
                imageSrc={!data?.data?.sections?.[0]?.videos?.[0] && data?.data?.sections?.[0]?.media?.[0]}
                videoSrc={data?.data?.sections?.[0]?.videos?.[0]}
                VideoPopupSrc={data?.data?.sections?.[0]?.videos?.[0]}
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
