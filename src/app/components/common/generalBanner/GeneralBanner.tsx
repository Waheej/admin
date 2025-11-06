"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralForm from "@/app/components/common/generalForm/GeneralForm";
import GeneralVideo from "@/app/components/common/generalVideo/GeneralVideo";
import VideoElement from "@/app/components/common/videoElement/VideoElement";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { downLoadIcon, playVideo, sendIcon } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import { useInitialLoader } from "@/app/store/useInitialLoader";
import { useLoadingRoutePage } from "@/app/store/useLoadingRoutePage";
import useToggleMenu from "@/app/store/useToggleMenu";
import { useGSAP } from "@gsap/react";
import clsx from "clsx";
import gsap from "gsap";
import { useLenis } from "lenis/react";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React, { useEffect, useRef } from "react";

type TGeneralBanner = {
    customClass?: string;
    isVideo?: boolean;
    imageSrc?: string;
    videoSrc?: string;
    title?: string;
    description?: string;
    sub_title?: string;
    VideoPopupSrc?: string;
    isDownloadBorochure?: boolean;
    enquiry_btn?: string;
    download_btn?: string;
    projectLogo?: string;
};

const GeneralBanner: React.FC<TGeneralBanner> = ({
    customClass,
    isVideo,
    imageSrc,
    videoSrc,
    title,
    description,
    sub_title,
    VideoPopupSrc,
    isDownloadBorochure,
    enquiry_btn,
    download_btn,
    projectLogo,
}) => {
    const setChildren = useGeneralPopUp((state) => state.setChildren);
    const t = useTranslations();
    const containerRef = useRef<HTMLDivElement>(null);
    const { visible } = useInitialLoader();
    const { isTransitioning } = useLoadingRoutePage();
    const tl = useRef<gsap.core.Timeline | null>(null);

    useGSAP(
        () => {
            if (!containerRef.current) return;

            const mediaContainer = containerRef.current.querySelector(".general-banner-media-container");
            const bannerEle = containerRef.current.querySelectorAll(".banner-ele");
            const header = document.querySelector(".header");
            const bannerLayer = containerRef.current.querySelector(".general-banner-image-overlay");

            // ✅ Set initial states
            gsap.set(mediaContainer, { width: 0 });
            gsap.set(bannerLayer, { opacity: 0 });
            gsap.set(bannerEle, { opacity: 0, y: 50 });
            gsap.set(header, { opacity: 0, y: -50 });

            const timeline = gsap.timeline({ paused: true });

            timeline
                .to(mediaContainer, { width: "100%", duration: 1, ease: "power3.out" })
                .to(bannerLayer, { opacity: 1, duration: 1, ease: "power3.out" }, "-=0.5")
                .to(bannerEle, { opacity: 1, y: 0, duration: 1, ease: "power3.out", stagger: 0.1, clearProps: "all" }, "-=0.5")
                .to(header, { opacity: 1, y: 0, duration: 1, ease: "power3.out" }, "-=0.5");

            tl.current = timeline;
        },
        { scope: containerRef, dependencies: [] },
    );

    useEffect(() => {
        if (!tl.current) return;

        if (visible || isTransitioning) {
            tl.current.reverse();
        } else {
            tl.current.play();
        }
    }, [visible, isTransitioning]);
    const lang = useLocale();
    const lenis = useLenis();
    const { closeMenu } = useToggleMenu();
    return (
        <section
            ref={containerRef}
            className={clsx("general-banner h-screen flex xl:flex-row-reverse lg:flex-row-reverse md:flex-row-reverse flex-col items-center gap-4 relative snap-start", customClass)}>
            <div className="general-banner-image relative overflow-hidden w-full h-full rounded-3xl">
                <div className="general-banner-media-container w-full h-full relative">
                    {isVideo ? <GeneralVideo loop src={videoSrc} autoPlay muted /> : imageSrc && <ParallaxImage src={imageSrc} alt={`${title}-image`} priority={true} sizes="(max-width: 768px) 100vw, (max-width: 1200px) 90vw, 80vw" />}
                </div>

                <div className="general-banner-image-overlay absolute inset-0 z-[1] bg-linear-to-b from-black/20 to-black/80 to-65%">
                    <GeneralContainer customClass="py-8">
                        <div className="general-banner-image-play text-white flex items-end gap-4 h-full">
                            <div
                                className={clsx("general-banner-content xl:max-w-[50%] lg:max-w-[40%] md:max-w-[40%] max-w-full", {
                                    "xl:max-w-[80%] lg:max-w-[80%] md:max-w-[80%] max-w-full": !sub_title,
                                })}>
                                {isVideo && VideoPopupSrc && (
                                    <div className="flex items-center gap-4 mb-32 cursor-pointer group w-fit banner-ele">
                                        <GeneralButton
                                            isWhite
                                            isPillEffect
                                            icon={playVideo}
                                            customClass="!w-16 !h-10 backdrop-filter backdrop-blur-sm duration-300 !bg-transparent border border-white/60 group-hover:!bg-white group-hover:!text-dark !text-white"
                                            customClick={() => setChildren(<VideoElement videoSrc={VideoPopupSrc} />, "video")}
                                        />
                                        <span className="capitalize text-xl">{t("common.play_video")}</span>
                                    </div>
                                )}
                                <div className="overflow-hidden">
                                    <h2 className="xl:text-5xl text-4xl uppercase banner-ele">{title}</h2>
                                </div>
                                {description && (
                                    <div className="overflow-hidden">
                                        <div className=" text-2xl text-white/80 my-4 banner-ele" dangerouslySetInnerHTML={{ __html: description }}></div>
                                    </div>
                                )}
                                <div className="overflow-hidden">
                                    <div className="flex items-center gap-4 flex-wrap banner-ele mt-4">
                                        {projectLogo && (
                                            <div className="project-card-page-image-content-button-logo bg-white flex items-center justify-center w-[150px] h-[3rem] rounded-full">
                                                <Image src={projectLogo} width={100} height={60} alt="Project Logo" className="mix-blend-exclusion" />
                                            </div>
                                        )}
                                        {/* {isDownloadBorochure && <GeneralButton title={t("common.download_brochure")} isWhite icon={downLoadIcon} isPillEffect />} */}
                                        {enquiry_btn && <GeneralButton title={enquiry_btn} isWhite icon={sendIcon} isPillEffect customClick={() => {
                                            const section = document.querySelector("#contact");
                                            if (section) {
                                                setTimeout(() => {
                                                    lenis?.start()
                                                    lenis?.scrollTo(section as HTMLElement, {
                                                        offset: 0,
                                                        duration: 2,
                                                        easing: (t) => 1 - Math.pow(1 - t, 3),
                                                    });
                                                }, 2000);
                                            } else {
                                                setChildren(<GeneralForm customClass="!bg-white mx-auto xl:w-1/2 lg:w-1/2 md:w-1/2 w-full p-8 rounded-2xl" />, "contact");
                                                closeMenu()
                                            }
                                        }} />}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </GeneralContainer>
                </div>
            </div>
        </section>
    );
};

export default GeneralBanner;
