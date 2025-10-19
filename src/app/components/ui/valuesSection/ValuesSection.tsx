"use client";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import React, { useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const ValuesSection = () => {
    const sectionRef = useRef<HTMLDivElement>(null);
    const t = useTranslations();

    const values = [
        {
            title: t("about.value_quality"),
            desc: t("about.value_quality_desc"),
            icon: (
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="text-primary">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
            ),
        },
        {
            title: t("about.value_innovation"),
            desc: t("about.value_innovation_desc"),
            icon: (
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="text-primary">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            ),
        },
        {
            title: t("about.value_trust"),
            desc: t("about.value_trust_desc"),
            icon: (
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="text-primary">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
            ),
        },
        {
            title: t("about.value_excellence"),
            desc: t("about.value_excellence_desc"),
            icon: (
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="text-primary">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            ),
        },
    ];

    useGSAP(
        () => {
            if (!sectionRef.current) return;

            const ctx = gsap.context(() => {
                // Header Animation - once only
                gsap.fromTo(
                    ".header-reveal",
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        stagger: 0.1,
                        scrollTrigger: {
                            trigger: sectionRef.current,
                            start: "top 70%",
                            once: true, // ✅ مرة واحدة بس
                        },
                    }
                );

                // Cards Animation - simplified
                gsap.fromTo(
                    ".value-card",
                    { opacity: 0, y: 20 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        stagger: 0.1,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: sectionRef.current,
                            start: "top 65%",
                            once: true, // ✅ مرة واحدة بس
                        },
                        clearProps: "all", // ✅ ينضف بعد الأنيميشن
                    }
                );
            }, sectionRef);

            return () => ctx.revert(); // ✅ cleanup صح
        },
        { scope: sectionRef }
    );

    return (
        <section ref={sectionRef} className="values-section bg-gray rounded-3xl">
            <GeneralContainer isSection>
                {/* Header */}
                <div className="text-center mb-16 space-y-4">
                    <div className="overflow-hidden">
                        <p className="uppercase text-primary header-reveal flex items-center justify-center">
                            <span className="inline-block w-2 h-2 rounded-full bg-primary me-2 animate-pulse"></span>
                            {t("about.values_subtitle")}
                        </p>
                    </div>

                    <div className="overflow-hidden">
                        <h2 className="xl:text-6xl lg:text-5xl md:text-4xl text-3xl uppercase header-reveal">
                            {t("about.values_title")}
                        </h2>
                    </div>
                </div>

                {/* Values Grid */}
                <div className="grid xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                    {values.map((value, index) => (
                        <div
                            key={index}
                            className="value-card relative overflow-hidden rounded-3xl group cursor-pointer h-[350px] bg-white hover:shadow-xl transition-all duration-500">

                            {/* Content */}
                            <div className="relative h-full p-8 flex flex-col">
                                {/* Number - subtle */}
                                <div className="absolute top-6 end-6 text-7xl font-bold text-gray/60 transition-colors duration-500">
                                    0{index + 1}
                                </div>

                                {/* Icon Container */}
                                <div className="relative z-10 mb-8">
                                    <div className="w-16 h-16 bg-isabelline rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                                        <div className="transform group-hover:scale-110 transition-transform duration-300">
                                            {value.icon}
                                        </div>
                                    </div>
                                </div>

                                {/* Text Content */}
                                <div className="relative z-10 space-y-3 flex-1">
                                    {/* Title */}
                                    <h3 className="text-2xl font-[500] uppercase text-dark transition-colors duration-300">
                                        {value.title}
                                    </h3>
                                    
                                    {/* Decorative line */}
                                    <div className="w-8 h-0.5 bg-dark/20 rounded-full group-hover:w-16 transition-all duration-500"></div>

                                    {/* Description */}
                                    <p className="text-dark/60 leading-relaxed pt-2">
                                        {value.desc}
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </GeneralContainer>
        </section>
    );
};

export default ValuesSection;

