"use client";
import CustomTabs from "@/app/components/common/customTabs/CustomTabs";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import LogoLoop from "@/app/components/module/logoLoop/LogoLoop";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React, { useEffect, useMemo, useRef, useState } from "react";
import { GoArrowRight } from "react-icons/go";

gsap.registerPlugin(ScrollTrigger);

type PartnersAndSubsidiaries = {
    id: number;
    name: string;
    description: string;
    img: string;
    url: string;
    type: string;
};
type PartnersSuccessSectionProps = {
    partner: PartnersAndSubsidiaries[];
    subsidiary: PartnersAndSubsidiaries[];
};

const PartnersSuccessSection = ({ partners_and_subsidiaries }: { partners_and_subsidiaries: PartnersSuccessSectionProps }) => {
    const sectionRef = useRef<HTMLDivElement>(null);
    const t = useTranslations();
    const userLang = useLocale();
    // تحديد أول tab متاح بناءً على البيانات
    const initialTab = useMemo(() => {
        if (partners_and_subsidiaries?.partner && partners_and_subsidiaries.partner.length > 0) {
            return "partner";
        }
        if (partners_and_subsidiaries?.subsidiary && partners_and_subsidiaries.subsidiary.length > 0) {
            return "subsidiary";
        }
        return "partner"; // default fallback
    }, [partners_and_subsidiaries]);

    const [activeTab, setActiveTab] = useState(initialTab);

    // تحديث activeTab لما البيانات توصل
    useEffect(() => {
        if (initialTab && initialTab !== activeTab) {
            setActiveTab(initialTab);
        }
    }, [initialTab]);

    // فلترة البيانات حسب النوع مع إضافة sizes للـ Bento Grid
    const { partnersData, subsidiariesData, tabsData } = useMemo(() => {
        const partners = partners_and_subsidiaries?.partner || [];
        const subsidiaries = partners_and_subsidiaries?.subsidiary || [];

        // إضافة sizes بناءً على الترتيب للـ Bento Grid effect
        const addSizes = (items: any[]) => {
            return items.map((item: any, index: number) => {
                let size = "small";
                if (index === 0) size = "large";
                else if (index % 3 === 1 || index % 3 === 2) size = "medium";

                return {
                    ...item,
                    size,
                };
            });
        };

        // إنشاء الـ tabs بناءً على البيانات الموجودة
        const tabs = [];
        if (partners && partners.length > 0) {
            tabs.push({ label: t("about.partners"), value: "partner" });
        }
        if (subsidiaries && subsidiaries.length > 0) {
            tabs.push({ label: t("about.subsidiary"), value: "subsidiary" });
        }

        return {
            partnersData: addSizes(partners),
            subsidiariesData: addSizes(subsidiaries),
            tabsData: tabs,
        };
    }, [partners_and_subsidiaries, t]);

    const currentPartners = activeTab === "partner" ? partnersData : subsidiariesData;

    // Header Animation - once only
    useGSAP(
        () => {
            if (!sectionRef.current || !partners_and_subsidiaries) return;

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: sectionRef.current,
                    start: "top 70%",
                    once: true,
                },
            });

            tl.fromTo(".partners-header .reveal-ele", { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.8, stagger: 0.1 });

            return () => tl.kill();
        },
        { scope: sectionRef, dependencies: [partners_and_subsidiaries] },
    );

    useGSAP(
        () => {
            if (!currentPartners || currentPartners.length === 0) return;

            gsap.fromTo(
                ".partner-card",
                { opacity: 0, y: 20, scale: 0.95 },
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.5,
                    stagger: 0.08,
                    ease: "power2.out",
                    clearProps: "all",
                },
            );
        },
        { dependencies: [activeTab, currentPartners] },
    );

    // Get card classes based on size (Bento Grid)
    const getCardClasses = (size: string, index: number) => {
        const baseClasses = "partner-card relative overflow-hidden rounded-3xl group cursor-pointer";

        if (size === "large") {
            return `${baseClasses} xl:col-span-2 lg:col-span-2 xl:row-span-2 lg:row-span-2 h-[400px]`;
        }
        if (size === "medium") {
            return `${baseClasses} xl:col-span-2 lg:col-span-2 h-[300px]`;
        }
        return `${baseClasses} h-[300px]`;
    };

    return (
        <section ref={sectionRef} className="partners-success-section bg-isabelline rounded-3xl">
            <GeneralContainer isSection>
                {/* Header */}
                <div className="partners-header text-center mb-12 space-y-4">
                    <div className="overflow-hidden">
                        <p className="uppercase text-primary reveal-ele flex items-center justify-center">
                            <span className="inline-block w-2 h-2 rounded-full bg-primary me-2 animate-pulse"></span>
                            {t("about.partners_subtitle")}
                        </p>
                    </div>

                    <div className="overflow-hidden">
                        <h2 className="xl:text-6xl lg:text-5xl md:text-4xl text-3xl uppercase reveal-ele">{t("about.partners_title")}</h2>
                    </div>
                </div>

                {/* Tabs - يظهر بس لو في أكتر من نوع */}
                {tabsData && tabsData.length > 1 && (
                    <div className="flex justify-center mb-12">
                        <CustomTabs tabsData={tabsData} activeTab={activeTab} setActiveTab={setActiveTab} />
                    </div>
                )}

                {/* Partners Bento Grid */}
                {currentPartners && currentPartners.length > 0 && (
                    <div className="partners-grid grid xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6 auto-rows-auto perspective-1000">
                        {currentPartners.map((partner, index) => (
                            <div
                                key={`${activeTab}-${partner.id}`}
                                className={getCardClasses(partner.size, index)}
                                style={{
                                    transformStyle: "preserve-3d",
                                }}>
                                {/* Simple hover background */}
                                <div className="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                {/* Content */}
                                <div className="relative h-full bg-white rounded-3xl p-8 flex flex-col justify-between">
                                    {/* Logo */}
                                    {partner.img && (
                                        <div className="flex items-center justify-center flex-1">
                                            <div className="relative w-full h-32">
                                                <Image
                                                    src={partner.img || "/images/logo/logo-dark.png"}
                                                    alt={partner.name}
                                                    fill
                                                    className="object-contain filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-300"
                                                />
                                            </div>
                                        </div>
                                    )}

                                    {/* Info - slides up on hover */}
                                    <div className="space-y-2 text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <h3 className="font-bold text-lg uppercase">{partner.name}</h3>
                                        <div className="text-sm text-dark/60" dangerouslySetInnerHTML={{ __html: partner.description }} />
                                        {partner.url && (
                                            <GeneralButton
                                                isBlack
                                                isPillEffect
                                                isFlip={userLang !== "ar"}
                                                icon={<GoArrowRight size={20} />}
                                                customClass="inline-block mt-2 text-primary text-xs"
                                                title={t("about.visit_website")}
                                                url={partner.url} />
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </GeneralContainer>
        </section>
    );
};

export default PartnersSuccessSection;
