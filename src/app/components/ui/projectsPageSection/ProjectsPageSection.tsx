"use client";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import ProjectCardPage from "@/app/components/common/projectCardPage/ProjectCardPage";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import React, { useEffect, useMemo, useRef, useState } from "react";
gsap.registerPlugin(ScrollTrigger);

const ProjectsPageSection = ({ data }: any) => {
    const t = useTranslations();
    const [activeTab, setActiveTab] = useState("all");
    const containerRef = useRef<HTMLDivElement | null>(null);

    // 🧠 Build the tabs dynamically
    const projectType = useMemo(() => {
        if (!data) return [];
        const types = data.map((item: any) => ({
            label: item?.apartment_type_value,
            value: item?.apartment_type_key,
        }));

        // إزالة التكرار (لو فيه أكتر من مشروع بنفس النوع)
        const uniqueTypes = Array.from(
            new Map(types.map((t:any) => [t.value, t])).values()
        );

        return [{ label: t("pages.all"), value: "all" }, ...uniqueTypes];
    }, [data]);

    // 🧩 Filter data based on active tab
    const filteredProjects = useMemo(() => {
        if (activeTab === "all") return data;
        return data.filter(
            (item: any) => item.apartment_type_key === activeTab
        );
    }, [activeTab, data]);

    // 🌀 GSAP animations
    useEffect(() => {
        if (!containerRef.current) return;

        const ctx = gsap.context(() => {
            const cards = gsap.utils.toArray(".project-card-page");

            cards.forEach((card: any) => {
                const img = card.querySelector(".project-card-page-image");
                const contentEls = card.querySelectorAll(".reveal-ele");

                gsap.set(img, { y: 100, opacity: 0 });

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        once: true,
                    },
                });

                tl.to(img, {
                    y: 0,
                    opacity: 1,
                    duration: 1.6,
                    ease: "power4.out",
                });

                tl.fromTo(
                    contentEls,
                    { y: 30, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        ease: "power3.out",
                        stagger: 0.12,
                    },
                    "-=1"
                );
            });

            ScrollTrigger.refresh();
        }, containerRef);

        return () => ctx.revert();
    }, [filteredProjects]);

    return (
        <section ref={containerRef} className="project-page-section">
            <GeneralContainer isSection>
                <HeaderSection
                    title={t("pages.latest_launches")}
                    sub_title={t("pages.projects_subtitle")}
                    showTabs
                    tabsData={projectType as any}
                    activeTab={activeTab}
                    setActiveTab={setActiveTab}
                    customClass="border-b border-black/10 pb-8"
                />

                <div className="project-page-section-container flex flex-col gap-4">
                    {filteredProjects?.length > 0 ? (
                        filteredProjects.map((project: any, index: number) => (
                            <ProjectCardPage
                                key={project.id}
                                reversed={index % 2 !== 0}
                                data={project}
                            />
                        ))
                    ) : (
                        <p className="text-center py-8 text-gray-500">
                            لا توجد مشاريع لهذا النوع حاليًا
                        </p>
                    )}
                </div>
            </GeneralContainer>
        </section>
    );
};

export default ProjectsPageSection;
