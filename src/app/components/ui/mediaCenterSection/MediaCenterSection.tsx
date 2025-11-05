"use client";
import CustomTabs from "@/app/components/common/customTabs/CustomTabs";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import Image from "next/image";
import React, { useState, useEffect, useRef } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import { LuPlus } from "react-icons/lu";
import { Link } from "@/i18n/navigation";
import { useTranslations } from "next-intl";

gsap.registerPlugin(ScrollTrigger);

const MediaCenterSection = ({ data }: { data: any }) => {
    const t = useTranslations();
    const tabsData = [
        { label: t("pages.all"), value: "all" },
        { label: t("pages.press_release"), value: "press_release" },
        { label: t("pages.news"), value: "news" },
    ];

    const [activeTab, setActiveTab] = useState("all");

    const arrayLength = data?.length || 10;

    const containerRef = useRef<HTMLDivElement | null>(null);

    useEffect(() => {
        if (!containerRef.current) return;

        const ctx = gsap.context(() => {
            const cards = gsap.utils.toArray(".media-center-card");

            cards.forEach((card: any) => {
                const img = card.querySelector(".media-center-image");
                const contentEls = card.querySelectorAll(".reveal-ele");

                // إعداد أولي
                gsap.set(img, { y: 100, opacity: 0 });
                gsap.set(contentEls, { y: 30, opacity: 0 });

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        once: true,
                    },
                });

                // الصورة
                tl.to(img, {
                    y: 0,
                    opacity: 1,
                    duration: 1.4,
                    ease: "power4.out",
                });

                // النصوص بعد الصورة
                tl.to(
                    contentEls,
                    {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        ease: "power3.out",
                        stagger: 0.12,
                    },
                    "-=1" // تبدأ أثناء نهاية حركة الصورة
                );
            });

            ScrollTrigger.refresh();
        }, containerRef);

        return () => ctx.revert();
    }, [activeTab]);


    return (
        <section data-parallax data-speed="0.2" className="media-center-section">
            <GeneralContainer isSection>
                <HeaderSection title={t("pages.latest_insights")} sub_title={t("pages.news")}  tabsData={tabsData} activeTab={activeTab} setActiveTab={setActiveTab} customClass="border-b border-black/10 pb-8"/>
                <div ref={containerRef} className="media-center-container grid grid-cols-12 gap-6 auto-rows-auto md:auto-rows-[300px]">
                    {data?.map((item: any, index: number) => {
                        const pos = index % 5;

                        let baseClasses = "media-center-card flex flex-col h-[45vh] md:h-auto"; 
                        if (pos === 0) {
                            baseClasses += " col-span-12 lg:col-span-6 row-span-2";
                        } else if (pos === 1) {
                            baseClasses += " col-span-12 sm:col-span-6 lg:col-span-3";
                        } else if (pos === 2) {
                            baseClasses += " col-span-12 sm:col-span-6 lg:col-span-3";
                        } else if (pos === 3) {
                            baseClasses += " col-span-12 sm:col-span-6 lg:col-span-3";
                        } else if (pos === 4) {
                            baseClasses += " col-span-12 sm:col-span-6 lg:col-span-3";
                        }

                        return (
                            <Link href={`/media-center/${item.id}?type=news`} key={index} className={baseClasses}>
                                <div className="media-center-image relative flex-grow rounded-3xl overflow-hidden">
                                    <ParallaxImage src={item.media_path || "/images/media-center.png"} alt="image" />
                                    {/* <div className="media-center-image-overlay inset-0 z-[1] absolute w-full h-full bg-linear-to-b from-transparent to-black/80 to-65% top-0 left-0 p-4 rounded-3xl overflow-hidden">
                                        <div className="media-center-image-overlay-label bg-primary text-white w-fit h-8 text-sm font-[500] flex items-center justify-center px-4 rounded-lg uppercase">
                                            {t("pages.press_release")}
                                        </div>
                                    </div> */}
                                </div>
                                <div className="media-center-image-content mt-4">
                                    <div className="overflow-hidden">
                                        <span className="text-gray-400 uppercase text-lg reveal-ele inline-block">{item.created_at }</span>
                                    </div>
                                    <div className="overflow-hidden">
                                        <h2 className="text-dark uppercase text-xl mt-2 reveal-ele">{item.title}</h2>
                                    </div>
                                </div>
                            </Link>
                        );
                    })}
                </div>
                {/* <GeneralButton title={t("btn_text.load_more")} customClass=" mx-auto mt-8 bg-primary text-white" icon={<LuPlus size={20} />} isPillEffect/> */}
            </GeneralContainer>
        </section>
    );
};

export default MediaCenterSection;
