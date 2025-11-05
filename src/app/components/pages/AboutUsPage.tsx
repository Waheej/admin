"use client";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import ContactSection from "@/app/components/ui/contactSection/ContactSection";
import PartnersSuccessSection from "@/app/components/ui/partnersSuccessSection/PartnersSuccessSection";
import ValuesSection from "@/app/components/ui/valuesSection/ValuesSection";
import VisionMissionSection from "@/app/components/ui/visionMissionSection/VisionMissionSection";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React, { Fragment } from "react";

const AboutUsPage = () => {
    const t = useTranslations();
    const userLang = useLocale();
    const { data, isLoading, isError, error } = useQuery({
        queryKey: ["aboutUsPage", userLang],
        queryFn: async () => {
            try {
                const res = await handleFetchRequest("aboutUsPage", "GET", null, userLang);
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
            <GeneralBanner title={t("menu.about_us")} imageSrc={"/images/about_us.png"} />
            <VisionMissionSection mission={data?.data?.sections?.mission} vision={data?.data?.sections?.vision} />
            <ValuesSection />
            <PartnersSuccessSection partners_and_subsidiaries={data?.data?.sections?.partners_and_subsidiaries} />
            <ContactSection />
        </Fragment>
    );
};

export default AboutUsPage;
