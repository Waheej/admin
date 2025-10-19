"use client";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralForm from "@/app/components/common/generalForm/GeneralForm";
import GeneralInput from "@/app/components/common/generalInput/GeneralInput";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import RevealText from "@/app/components/module/revealText/RevealText";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useQuery } from "@tanstack/react-query";
import { Form, Formik } from "formik";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React, { useMemo } from "react";
import { BiLogoTiktok } from "react-icons/bi";
import { FaFacebookF, FaInstagram, FaSnapchatGhost } from "react-icons/fa";
import { FaXTwitter } from "react-icons/fa6";
import { FiSend } from "react-icons/fi";

const ContactSection = ({data}:any) => {
    const t = useTranslations();
    const lang = useLocale();
    const getIconByKey = (key: string) => {
        const iconMap: Record<string, any> = {
            facebook: <FaFacebookF size={20} />,
            instagram: <FaInstagram size={20} />,
            tiktok: <BiLogoTiktok size={20} />,
            snapchat: <FaSnapchatGhost size={20} />,
            x: <FaXTwitter size={20} />,
        };
        return iconMap[key] || <FiSend size={20} />;
    };
    const { data: infoData } = useQuery({
        queryKey: ["getInfo", lang],
        queryFn: () => handleFetchRequest("getInfo", "GET", null, lang),
        staleTime: 1000 * 60 * 5,
    });
    const socialMedia = useMemo(() => {
        if (!infoData?.data) return [];
        return infoData.data.filter((item: any) => ["facebook", "instagram", "tiktok", "snapchat", "x", "twitter"].includes(item.key));
    }, [infoData]);
    return (
        <section className="contact-section bg-gray rounded-3xl" id="contact" data-parallax >
            <GeneralContainer isSection customClass="flex justify-between flex-wrap gap-8">
                <div className="contact-section-title xl:max-w-1/2 lg-max-w-1/3 md:max-w-1/2 max-w-full">
                    <HeaderSection title={data?.title}   customClass="!mb-0" />
                    <div className="contact-section-title-follow">
                        <span className="text-dark/70 inline-block reveal-ele">{t("common.follow_us")}</span>
                        <div className="contact-section-title-follow-btn flex items-center gap-2 mt-4">
                            {
                                socialMedia.length > 0 && (
                                    socialMedia.map((social: any) => (
                                        <GeneralButton
                                            key={social.id}
                                            icon={getIconByKey(social.key)}
                                            isBlack
                                            isPillEffect
                                            customClass="duration-300 transition-colors"
                                            customClick={() => window.open(social.value, "_blank")}
                                        />
                                    ))
                                )
                            }
                        </div>
                        
                    </div>
                </div>
                <div className="contact-section-title-form xl:w-1/2 lg:w-1/2 md:w-1/2 w-full">
                    <GeneralForm />
                    
                </div>
            </GeneralContainer>
        </section>
    );
};

export default ContactSection;
