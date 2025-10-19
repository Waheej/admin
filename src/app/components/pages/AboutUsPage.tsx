"use client";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import ContactSection from "@/app/components/ui/contactSection/ContactSection";
import PartnersSuccessSection from "@/app/components/ui/partnersSuccessSection/PartnersSuccessSection";
import ValuesSection from "@/app/components/ui/valuesSection/ValuesSection";
import VisionMissionSection from "@/app/components/ui/visionMissionSection/VisionMissionSection";
import { useTranslations } from "next-intl";
import React, { Fragment } from "react";

const AboutUsPage = () => {
    const t = useTranslations();
    
    return (
        <Fragment>
            <GeneralBanner 
                title={t("menu.about_us")}
                description="Real State In Saudi Arabia: idea for living and investing"  
                imageSrc="/images/about.png" 
            />
            <VisionMissionSection />
            <ValuesSection />
            <PartnersSuccessSection />
            <ContactSection />
        </Fragment>
    );
};

export default AboutUsPage;
