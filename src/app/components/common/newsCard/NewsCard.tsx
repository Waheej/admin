import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import clsx from "clsx";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React from "react";
import { GoArrowUpRight } from "react-icons/go";

const NewsCard = ({ newsData }:any) => {
    const t = useTranslations()
    const lang = useLocale()
    return (
        <div className={clsx("news-card xl:h-[60vh] lg:h-[60vh] md:h-[60vh] h-fit rounded-2xl overflow-hidden relative bg-white flex xl:flex-row lg:flex-row md:flex-row flex-col justify-between xl:gap-10 lg:gap-10 md:gap-8 gap-4 p-6")}>
            <div className="news-card-content flex flex-col justify-between gap-4">
                <div className="news-card-content-label">
                    <span className="news-card-content-label-item xl:text-sm lg:text-sm md:text-sm text-xs uppercase px-4 py-1 rounded-full bg-gray/70 h-10 flex items-center justify-center w-fit">News</span>
                </div>
                <div className="news-card-content-title flex flex-col gap-4">
                    <h2 className="xl:text-4xl lg:text-4xl md:text-4xl text-3xl">{newsData?.title }</h2>
                    <p className="text-dark/80 xl:text-lg lg:text-lg md:text-lg text-sm" dangerouslySetInnerHTML={{ __html: newsData?.description }}></p>
                </div>
                <GeneralButton icon={<GoArrowUpRight size={18} />} title={t("btn_text.read_more")} isBlack isPillEffect isFlip={lang !== "ar" } url={`/media-center/${newsData?.id}`}/>
            </div>
            <div className="news-card-image xl:w-2/4 lg:w-2/4 md:w-1/2 w-full xl:h-full lg:h-full md:h-full h-[20vh] relative rounded-2xl overflow-hidden shrink-0">
                <ParallaxImage src={newsData?.media_path || "/images/banner.png"} alt="News Card" />
            </div>
        </div>
    );
};

export default NewsCard;
