"use client"
import FilterTabs from "@/app/components/common/filterTabs/FilterTabs";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import ProjectCard from "@/app/components/common/projectCard/ProjectCard";
import UnitCard from "@/app/components/common/unitCard/UnitCard";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { plusIcon } from "@/app/data/data";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useTranslations } from "next-intl";
import React from "react";
import { LuPlus } from "react-icons/lu";
gsap.registerPlugin(useGSAP,ScrollTrigger)
const FeaturedProjects = ({data}:any) => {
    const containerRef = React.useRef<HTMLDivElement>(null)
    const t = useTranslations()
    useGSAP(() => {
        if (!containerRef.current || !data?.data?.length) return;
        const cards = containerRef.current.querySelectorAll(".project-card");
        if (cards.length === 0) return;
        
        gsap.fromTo(
            cards,
            { yPercent: 20, opacity: 0 },
            {
                yPercent: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out",
                stagger: 0.08,
                scrollTrigger: {
                    trigger: containerRef.current,
                    start: "top 85%",
                    toggleActions: "play none none none",
                    once: true,
                },
            }
        );
    }, {
        scope: containerRef,
        dependencies: [data?.data]
    });

    return (
        <section data-parallax ref={containerRef} className="featured-project overflow-hidden bg-isabelline rounded-3xl">
            <GeneralContainer isSection>
                <HeaderSection title={data?.title} description={data?.description } showBtn btnTitle={t("btn_text.veiw_all_projects")} btnUrl="/projects" />
                {/* <FilterTabs btnUrl="/projects" btnText={t("btn_text.veiw_all_projects")} /> */}
                <div className="featured-project-container grid xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 grid-cols-1 mt-8 gap-6">
                    {data?.data?.map((data: any, index: any) => (
                        data?.units?.map((unit: any) => (
                            <UnitCard data={unit} key={unit.id} showProjectLabel isLink/>
                        ))
                    ))}
                </div>
                {/* <GeneralButton title={t("btn_text.load_more")} customClass="mt-8 mx-auto" isBlack isPillEffect icon={plusIcon}/> */}
            </GeneralContainer>
        </section>
    );
};

export default FeaturedProjects;
