"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import ProjectDetails from "@/app/components/common/projectDetails/ProjectDetails";
import ProjectsPagination from "@/app/components/common/projectDetails/ProjectsPagination";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import { currancyIcon, currencySAR } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import { useGSAP } from "@gsap/react";
import clsx from "clsx";
import gsap from "gsap";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React, { use, useEffect } from "react";
import { GoArrowRight, GoArrowUpRight } from "react-icons/go";
import { GrLocation } from "react-icons/gr";
import { PiBuildingApartment } from "react-icons/pi";
gsap.registerPlugin(useGSAP);
const ProjectCard = ({ project_data, index }: any) => {
    const t = useTranslations();
    const { setChildren } = useGeneralPopUp((state) => state);
    const cardRef = React.useRef<HTMLDivElement>(null);
    const [screenWidth, setScreenWidth] = React.useState(typeof window !== "undefined" ? window.innerWidth : 1024);
    useEffect(() => {
        const handleResize = () => {
            setScreenWidth(window.innerWidth);
        };
        window.addEventListener("resize", handleResize);
        return () => {
            window.removeEventListener("resize", handleResize);
        };
    }, []);
    const lang =useLocale()
    useGSAP(
        () => {
            if (!cardRef.current) return;

            const image = cardRef.current.querySelector(".project-card-image");
            const overlay = cardRef.current.querySelector(".project-card-image-overlay");

            const tl = gsap.timeline({ defaults: { ease: "power3.inOut" }, paused: true });
            tl.to(image, { width: "96%", height: "35%", marginBottom: "15px", duration: 1 })
                .to(".project-card-image-overlay-top", { opacity: 0, duration: 1 }, 0)
                .to(".project-card-image-overlay-bottom", { opacity: 0, duration: 1 }, 0)
                .to(overlay, { opacity: 0, duration: 1 }, 0)
                .fromTo(".project-label", { opacity: 0, scale: 0.8 }, { opacity: 1, scale: 1, stagger: 0.1, duration: 1 }, 0)
                .fromTo(".project-reveal", { opacity: 0, y: 50 }, { opacity: 1, y: 0, stagger: 0.1, duration: 1 }, 0)
                .fromTo(".project-btn", { opacity: 0, scale: 0.5 }, { opacity: 1, scale: 1, duration: 1 }, 0);

            if (screenWidth < 1024) {
                tl.play();
            } else {
                const handleCardMouseEnter = () => tl.restart();
                const handleCardMouseLeave = () => tl.reverse();

                cardRef.current.addEventListener("mouseenter", handleCardMouseEnter);
                cardRef.current.addEventListener("mouseleave", handleCardMouseLeave);

                return () => {
                    cardRef.current?.removeEventListener("mouseenter", handleCardMouseEnter);
                    cardRef.current?.removeEventListener("mouseleave", handleCardMouseLeave);
                };
            }
        },
        { scope: cardRef },
    );

    return (
        <div ref={cardRef} className="project-card xl:h-[60vh] lg:h-[60vh] md:h-[60vh] h-[70vh] rounded-3xl bg-white overflow-hidden relative">
            <div className="project-card-content h-[60%] absolute top-0 left-0 p-4  w-full flex flex-col justify-between overflow-hidden">
                <div className="project-card-content-top flex items-center justify-between flex-wrap border-b border-black/10 pb-4 gap-4">
                    <div className="project-card-content-top-info flex items-center gap-2 place-content-center place-items-center">
                        {/* <span className="text-2xl project-label">{`0${index}` }</span> */}
                        {project_data?.city && (
                            <div className="project-label min-h-8 px-4 flex items-center justify-center border border-dark/40 text-dark/80 rounded-2xl gap-2 place-items-center place-content-center">
                                <GrLocation size={16} />
                                <span>{project_data?.city}</span>
                            </div>
                        )}

                        {project_data?.apartment_type_value && (
                            <div className="project-label min-h-8 px-4 flex items-center justify-center border border-dark/40 text-dark/80 rounded-2xl gap-2 place-items-center place-content-center">
                                <PiBuildingApartment size={16} />
                                <span>{project_data?.apartment_type_value}</span>
                            </div>
                        )}
                    </div>
                    {project_data?.price && (
                        <div className="project-label min-h-8 px-4 flex items-center justify-center border border-dark/40 !text-dark/80 rounded-2xl gap-2 place-items-center place-content-center">
                            <span className="!text-dark/80">
                            {currancyIcon}

                            </span>
                            <span>{`${project_data?.price} ${lang === "ar" ? "ريال" : "SAR"}`}</span>
                        </div>
                    )}
                </div>
                <div className="project-card-content-bottom pt-6 flex justify-between items-end gap-2 flex-wrap ">
                    <div className="project-card-content-bottom-info xl:max-w-1/2 lg:max-w-1/2 md:max-w-1/2 max-w-full">
                        {/* <div className="overflow-hidden">
                            <p className="text-md mb-2 capitalize project-reveal line-clamp-1">
                                <span className="text-dark/70">Developer:</span>
                                <span>LuxeLine Properties</span>
                            </p>
                        </div> */}

                        <div className="overflow-hidden">
                            <h2 className="text-3xl capitalize project-reveal line-clamp-2">{`0${index} - ${project_data?.name}`}</h2>
                        </div>
                    </div>
                    <GeneralButton
                        title={t("btn_text.read_more")}
                        customClass={clsx("!text-sm project-btn")}
                        isFlip
                        isBlack
                        isPillEffect
                        url={`/projects/${project_data?.id}`}
                        // isProjectBtn
                        icon={<GoArrowRight size={20} />}
                        // customClick={() => {
                        //     setChildren(
                        //         <>
                        //             <ProjectDetails />
                        //             <ProjectsPagination />
                        //         </>,
                        //         "project",
                        //     );
                        // }}
                    />
                </div>
            </div>
            <div className="project-card-image xl:h-full lg:h-full md:h-full h-[40%] w-full absolute mx-auto bottom-0 left-1/2 -translate-x-1/2 rounded-3xl overflow-hidden">
                <ParallaxImage src={project_data?.image?project_data?.image:"/images/banner.png"} alt="project" />
                <div className="project-card-image-overlay absolute inset-0 bg-linear-to-b to-black/50 from-transparent  z-[1] w-full h-full p-4 flex flex-col justify-between rounded-3xl">
                    <div className="project-card-image-overlay-top flex items-center justify-between gap-4  w-full">
                        <div className="project-label min-h-8 px-4 flex items-center justify-center border border-white/40 text-white/80 rounded-2xl bg-dark/10 backdrop-blur-md gap-2 place-items-center place-content-center">
                            <GrLocation size={16} />
                            <span>Dmammss</span>
                        </div>
                    </div>
                    <div className="project-card-image-overlay-bottom flex flex-col text-white w-full max-w-3/4">
                        <span className="text-2xl mb-2">{`0${index}`}</span>
                        <h2 className="text-3xl capitalize">{project_data?.name}</h2>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ProjectCard;
