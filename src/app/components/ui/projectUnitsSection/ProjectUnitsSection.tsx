"use client";
import GeneralSwiper from "@/app/components/common/generalSwiper/GeneralSwiper";
import GeneralSwiperPagination from "@/app/components/common/generalSwiperPagination/GeneralSwiperPagination";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import UnitCard from "@/app/components/common/unitCard/UnitCard";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import React, { useEffect, useMemo, useRef, useState } from "react";
import { SwiperSlide } from "swiper/react";

gsap.registerPlugin(ScrollTrigger);

const ProjectUnitsSection = ({ projects }: { projects: any }) => {
    const t = useTranslations();
    const [activeTab, setActiveTab] = useState("all");
    const containerRef = useRef<HTMLDivElement>(null);

    // 🧠 Build tabs dynamically from projects data
    const projectTypes = useMemo(() => {
        if (!projects || projects.length === 0) return [{ label: "all", value: "all" }];
        
        const types = projects.map((item: any) => ({
            label: item?.apartment_type_value || item?.apartment_type_key,
            value: item?.apartment_type_key,
        }));

        // إزالة التكرار
        const uniqueTypes = Array.from(
            new Map(types.map((t: any) => [t.value, t])).values()
        );

        return [{ label: t("pages.all"), value: "all" }, ...uniqueTypes];
    }, [projects]);

    // 🧩 Filter projects based on active tab
    const filteredProjects = useMemo(() => {
        if (!projects) return [];
        if (activeTab === "all") return projects;
        return projects.filter((item: any) => item.apartment_type_key === activeTab);
    }, [activeTab, projects]);
    // 🌀 Animation on filter change
    useEffect(() => {
        if (!containerRef.current) return;

        const ctx = gsap.context(() => {
            gsap.fromTo(
                ".unit-card",
                { opacity: 0, y: 20 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.5,
                    stagger: 0.08,
                    ease: "power2.out",
                    clearProps: "all",
                }
            );
        }, containerRef);

        return () => ctx.revert();
    }, [activeTab]);

    return (
        projects?.length > 0 &&
        <section className="project-units-section" ref={containerRef}>
            <GeneralContainer isSection customClass="bg-gray rounded-3xl">
                <HeaderSection 
                    title={t("pages.units_title")}
                    description={t("pages.units_subtitle")}
                    tabsData={projectTypes as any} 
                    showTabs 
                    activeTab={activeTab} 
                    setActiveTab={setActiveTab} 
                    forceSelect 
                />
                
                <div className="project-units-section-units">
                    {filteredProjects?.length > 0 ? (
                        <>
                            {/* Desktop Grid - hidden on mobile */}
                            <div className="hidden md:grid xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 gap-6">
                                {filteredProjects.map((project: any) => (
                                    <div key={`${activeTab}-${project.id}`} className="unit-card">
                                        <UnitCard data={project} />
                                    </div>
                                ))}
                            </div>

                            {/* Mobile Swiper - shown only on mobile */}
                            <div className="block md:hidden">
                                <GeneralSwiper
                                    paginationElement=".swiper-units-pagination"
                                    autoplay={{ delay: 5000 }}
                                    loop={filteredProjects.length > 1}
                                    spaceBetween={20}
                                    breakpoints={{
                                        0: { slidesPerView: 1 },
                                    }}
                                >
                                    {filteredProjects.map((project: any) => (
                                        <SwiperSlide key={`${activeTab}-${project.id}`}>
                                            <div className="unit-card">
                                                <UnitCard data={project} />
                                            </div>
                                        </SwiperSlide>
                                    ))}
                                </GeneralSwiper>

                                <GeneralSwiperPagination customClass="swiper-units-pagination mt-8" />
                            </div>
                        </>
                    ) : (
                        <div className="text-center py-16">
                            <p className="text-dark/60">{t("pages.no_units_message")}</p>
                        </div>
                    )}
                </div>
            </GeneralContainer>
        </section>
    );
};

export default ProjectUnitsSection;
