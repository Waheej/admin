"use client";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import Image from "next/image";
import React, { useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const VisionMissionSection = () => {
    const visionRef = useRef<HTMLDivElement>(null);
    const missionRef = useRef<HTMLDivElement>(null);
    const t = useTranslations();

    // Vision Animation - simplified
    useGSAP(
        () => {
            if (!visionRef.current) return;

            const ctx = gsap.context(() => {
                gsap.fromTo(
                    ".reveal-ele",
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        stagger: 0.1,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: visionRef.current,
                            start: "top 70%",
                            once: true, // ✅ مرة واحدة بس
                        },
                        clearProps: "all",
                    }
                );
            }, visionRef);

            return () => ctx.revert();
        },
        { scope: visionRef }
    );

    // Mission Animation - simplified
    useGSAP(
        () => {
            if (!missionRef.current) return;

            const ctx = gsap.context(() => {
                gsap.fromTo(
                    ".reveal-ele",
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        stagger: 0.1,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: missionRef.current,
                            start: "top 70%",
                            once: true, // ✅ مرة واحدة بس
                        },
                        clearProps: "all",
                    }
                );
            }, missionRef);

            return () => ctx.revert();
        },
        { scope: missionRef }
    );

    return (
        <>
            {/* Vision Section */}
            <section ref={visionRef} className="vision-section bg-isabelline rounded-3xl">
                <GeneralContainer isSection>
                    <div className="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-10 items-center">
                        {/* Image */}
                        <div className="overflow-hidden rounded-3xl h-[60vh] relative reveal-ele">
                            <ParallaxImage
                                src="/images/about.png"
                                alt={t("about.vision_title")}
                            />
                        </div>

                        {/* Content */}
                        <div className="space-y-6">
                            <div className="overflow-hidden">
                                <p className="uppercase text-primary reveal-ele flex items-center">
                                    <span className="inline-block w-2 h-2 rounded-full bg-primary me-2 animate-pulse"></span>
                                    {t("about.vision_subtitle")}
                                </p>
                            </div>

                            <div className="overflow-hidden">
                                <h2 className="xl:text-6xl lg:text-5xl md:text-4xl text-3xl uppercase reveal-ele">
                                    {t("about.vision_title")}
                                </h2>
                            </div>

                            <div className="overflow-hidden">
                                <p className="text-lg text-dark/70 reveal-ele">
                                    {t("about.vision_desc")}
                                </p>
                            </div>
                        </div>
                    </div>
                </GeneralContainer>
            </section>

            {/* Mission Section */}
            <section ref={missionRef} className="mission-section bg-white">
                <GeneralContainer isSection>
                    <div className="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-10 items-center">
                        {/* Content - RTL/LTR aware */}
                        <div className="space-y-6 xl:order-1 lg:order-1 md:order-2 order-2">
                            <div className="overflow-hidden">
                                <p className="uppercase text-primary reveal-ele flex items-center">
                                    <span className="inline-block w-2 h-2 rounded-full bg-primary me-2 animate-pulse"></span>
                                    {t("about.mission_subtitle")}
                                </p>
                            </div>

                            <div className="overflow-hidden">
                                <h2 className="xl:text-6xl lg:text-5xl md:text-4xl text-3xl uppercase reveal-ele">
                                    {t("about.mission_title")}
                                </h2>
                            </div>

                            <div className="overflow-hidden">
                                <p className="text-lg text-dark/70 reveal-ele">
                                    {t("about.mission_desc")}
                                </p>
                            </div>
                        </div>

                        {/* Image */}
                        <div className="overflow-hidden reveal-ele rounded-3xl h-[60vh] relative xl:order-2 lg:order-2 md:order-1 order-1">
                         
                            <ParallaxImage
                                src="/images/about.png"
                                alt={t("about.mission_title")}
                            />
                        </div>
                    </div>
                </GeneralContainer>
            </section>
        </>
    );
};

export default VisionMissionSection;

