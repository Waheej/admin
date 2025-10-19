"use client";
import CustomTabs from "@/app/components/common/customTabs/CustomTabs";
import LogoLoop from "@/app/components/module/logoLoop/LogoLoop";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import Image from "next/image";
import React, { useRef, useState } from "react";

gsap.registerPlugin(ScrollTrigger);

const PartnersSuccessSection = () => {
    const sectionRef = useRef<HTMLDivElement>(null);
    const t = useTranslations();
    const [activeTab, setActiveTab] = useState("strategic");

    // Strategic Partners Data
    const strategicPartners = [
        {
            id: 1,
            logo: "/images/partners/partner1.svg",
            name: "Saudi Investment Bank",
            description: "Financial partner for real estate investments",
            size: "large", // للـ Bento Grid
        },
        {
            id: 2,
            logo: "/images/partners/partner2.svg",
            name: "Real Estate Fund",
            description: "Investment and development",
            size: "medium",
        },
        {
            id: 3,
            logo: "/images/partners/partner3.svg",
            name: "Construction Group",
            description: "Building and development",
            size: "medium",
        },
        {
            id: 4,
            logo: "/images/partners/partner1.svg",
            name: "Legal Advisory",
            description: "Legal consultation",
            size: "small",
        },
        {
            id: 5,
            logo: "/images/partners/partner2.svg",
            name: "Marketing Agency",
            description: "Marketing and branding",
            size: "small",
        },
    ];

    // Technology Partners Data
    const technologyPartners = [
        {
            id: 1,
            logo: "/images/partners/partner3.svg",
            name: "Smart Home Systems",
            description: "IoT and automation",
            size: "large",
        },
        {
            id: 2,
            logo: "/images/partners/partner1.svg",
            name: "Construction Tech",
            description: "Building technology",
            size: "medium",
        },
        {
            id: 3,
            logo: "/images/partners/partner2.svg",
            name: "PropTech Solutions",
            description: "Property technology",
            size: "medium",
        },
        {
            id: 4,
            logo: "/images/partners/partner3.svg",
            name: "Digital Platform",
            description: "Web solutions",
            size: "small",
        },
        {
            id: 5,
            logo: "/images/partners/partner1.svg",
            name: "Security Systems",
            description: "Smart security",
            size: "small",
        },
    ];

    const currentPartners = activeTab === "strategic" ? strategicPartners : technologyPartners;

    const tabsData = [
        { label: t("about.partners_strategic"), value: "strategic" },
        { label: t("about.partners_technology"), value: "technology" },
    ];

    // Header Animation - once only
    useGSAP(
        () => {
            if (!sectionRef.current) return;

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: sectionRef.current,
                    start: "top 70%",
                    once: true, // ✅ مرة واحدة بس
                },
            });

            tl.fromTo(
                ".partners-header .reveal-ele",
                { opacity: 0, y: 30 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1 }
            );

            return () => tl.kill();
        },
        { scope: sectionRef }
    );

    // Partners Animation - simplified for performance
    useGSAP(
        () => {
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
                    clearProps: "all", // ✅ ينضف الـ properties بعد الأنيميشن
                }
            );
        },
        { dependencies: [activeTab] }
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

                {/* Tabs */}
                <div className="flex justify-center mb-12">
                    <CustomTabs tabsData={tabsData} activeTab={activeTab} setActiveTab={setActiveTab} />
                </div>

                {/* Partners Bento Grid */}
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
                                <div className="flex items-center justify-center flex-1">
                                    <div className="relative w-full h-32">
                                        <Image 
                                            src={partner.logo} 
                                            alt={partner.name} 
                                            fill 
                                            className="object-contain filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-300" 
                                        />
                                    </div>
                                </div>

                                {/* Info - slides up on hover */}
                                <div className="space-y-2 text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <h3 className="font-bold text-lg uppercase">{partner.name}</h3>
                                    <p className="text-sm text-dark/60">{partner.description}</p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Simplified Logo Grid - بدل Logo Loop */}
                <div className="pt-16 relative">
                    <div className="flex items-center justify-center gap-8 flex-wrap grayscale hover:grayscale-0 transition-all duration-500">
                        {currentPartners.map((partner) => (
                            <div key={partner.id} className="relative w-32 h-20 opacity-60 hover:opacity-100 transition-opacity duration-300">
                                <Image
                                    src={partner.logo}
                                    alt={partner.name}
                                    fill
                                    className="object-contain"
                                />
                            </div>
                        ))}
                    </div>

                    {/* Decorative bottom text */}
                    <div className="text-center mt-8">
                        <p className="text-sm text-dark/40 uppercase tracking-wider">Trusted by industry leaders</p>
                    </div>
                </div>
            </GeneralContainer>
        </section>
    );
};

export default PartnersSuccessSection;
