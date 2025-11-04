"use client";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import Image from "next/image";
import React, { useRef, useEffect, useMemo } from "react";

gsap.registerPlugin(ScrollTrigger);

type Mission = {
    id?: number;
    title?: string;
    description?: string;
    media_path?: string;
    type?: string;
}
type VisionMissionSectionProps = {
    mission: Mission[];
    vision: Mission[];
}
const VisionMissionSection = ({ mission, vision }: VisionMissionSectionProps) => {
    console.log("Mission:", mission);
    console.log("Vision:", vision);

    const visionRef = useRef<HTMLDivElement>(null);
    const missionRef = useRef<HTMLDivElement>(null);
    const t = useTranslations();
    const missionData = useMemo(() => {
        const missionData = mission?.filter((item: any) => item.type === "mission");
        const visionData = mission?.filter((item: any) => item.type === "vision");
        return { missionData, visionData };
    }, [mission]);
    // Vision Animation - يشتغل بس لما الداتا توصل
    useGSAP(
        () => {
            if (!visionRef.current || !vision) return;

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
                            once: true,
                        },
                        clearProps: "all",
                    },
                );
            }, visionRef);

            return () => ctx.revert();
        },
        { scope: visionRef, dependencies: [missionData?.visionData] },
    );

    // Mission Animation - يشتغل بس لما الداتا توصل
    useGSAP(
        () => {
            if (!missionRef.current || !mission) return;

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
                            once: true,
                        },
                        clearProps: "all",
                    },
                );
            }, missionRef);

            return () => ctx.revert();
        },
        { scope: missionRef, dependencies: [missionData?.missionData] },
    );

    return (
        <>
            {/* Vision Section */}
            {missionData?.visionData?.length > 0 && (
                <section ref={visionRef} className="vision-section bg-isabelline rounded-3xl">
                    <GeneralContainer isSection>
                        <div className="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-10 items-center">
                            {/* Image */}
                            <div className="overflow-hidden rounded-3xl h-[60vh] relative reveal-ele">
                                <ParallaxImage src={missionData?.visionData?.[0]?.media_path || "/images/about.png"} alt={missionData?.visionData?.[0]?.title || "" } />
                            </div>

                            {/* Content */}
                            <div className="space-y-6">
                                <div className="overflow-hidden">
                                    <h2 className="xl:text-6xl lg:text-5xl md:text-4xl text-3xl uppercase reveal-ele">{missionData?.visionData?.[0]?.title }</h2>
                                </div>

                                <div className="overflow-hidden">
                                    <p className="text-lg text-dark/70 reveal-ele" dangerouslySetInnerHTML={{ __html: missionData?.visionData?.[0]?.description || "" }}></p>
                                </div>
                            </div>
                        </div>
                    </GeneralContainer>
                </section>
            )}

            {/* Mission Section */}
            {missionData?.missionData && (
                <section ref={missionRef} className="mission-section bg-white">
                    <GeneralContainer isSection customClass="px-0!">
                        <div className="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-10 items-center justify-between">
                            <div className="space-y-6 xl:order-1 lg:order-1 md:order-2 order-2">
                                <div className="overflow-hidden">
                                    <h2 className="xl:text-5xl lg:text-5xl md:text-4xl text-3xl uppercase reveal-ele">{missionData?.missionData?.[0]?.title}</h2>
                                </div>

                                <div className="overflow-hidden">
                                    <p className="text-lg text-dark/70 reveal-ele" dangerouslySetInnerHTML={{ __html: missionData?.missionData?.[0]?.description || "" }}></p>
                                </div>
                            </div>

                            {/* Image */}
                            <div className="overflow-hidden reveal-ele rounded-3xl h-[60vh] relative xl:order-2 lg:order-2 md:order-1 order-1">
                                <ParallaxImage src={missionData?.missionData?.[0]?.media_path || "/images/about.png"} alt={missionData?.missionData?.[0]?.title || ""} />
                            </div>
                        </div>
                    </GeneralContainer>
                </section>
            )}
        </>
    );
};

export default VisionMissionSection;
