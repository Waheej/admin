import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import { areaIcon, bedroomIcon, currancyIcon, meterSquareIcon, pdfIcon } from "@/app/data/data";
import { formatNumber } from "@/lib/utils";
import clsx from "clsx";
import { useLocale, useTranslations } from "next-intl";
import Link from "next/link";
import React from "react";
import { PiFilePdf } from "react-icons/pi";

const UnitCard = ({ data, showProjectLabel, isLink }: { data: any; showProjectLabel?: boolean ; isLink?: boolean }) => {
    const t = useTranslations();
    const lang = useLocale();
    return isLink ? (
        <Link href={`/projects/${data?.parent_id}`} className="unit-card p-4 rounded-3xl bg-white">
            <div className="unit-card-image relative h-80 overflow-hidden rounded-2xl">
                <ParallaxImage alt={data?.name} src={data?.image || "/images/banner.png"} />
                {showProjectLabel && <div className="unit-card-image-label rounded-full bg-primary text-white py-2 px-4 absolute z-[1] top-4 left-4 shadow-md">{data?.name}</div>}
                {/* <div className="unit-card-image-labels absolute z-[1] top-4 px-4 flex items-center gap-2">
                    <div className="label px-4 bg-primary text-white rounded-full py-2 uppercase text-sm flex items-center h-[3rem]">{t("btn_text.sold_out")}</div>
                    <GeneralButton icon={pdfIcon} isBlack />
                </div> */}
            </div>
            <div className="unit-card-content relative mt-10">
                <h3 className="text-3xl uppercase mb-4">{data?.name}</h3>
                <p className="line-clamp-2" dangerouslySetInnerHTML={{ __html: data?.description }}></p>
            </div>
            <div className="unit-card-details relative mt-6">
                <div className="unit-card-details-items flex items-center justify-between gap-8  p-4 flex-nowrap overflow-x-auto">
                    {/* <div className={clsx("unit-card-details-item flex flex-col gap-2 shrink-0 border-r border-gray pr-4 min-w-[120px]", {
                        "!pr-0 ps-4 !border-r-0 border-l": lang === "ar"
                    })}>
                        {areaIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">Area</span>
                        <span className="unit-card-details-item-value font-[500] flex items-center gap-1">140 - 160 {lang === "ar" ? "م²" : meterSquareIcon }</span>
                    </div>
                    <div className={clsx("unit-card-details-item flex flex-col gap-2 shrink-0 border-r border-gray pr-4 min-w-[120px]", {
                        "!pr-0 ps-4 !border-r-0 border-l": lang === "ar"
                    })}>
                        {bedroomIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">Bedrooms</span>
                        <span className="unit-card-details-item-value font-[500]">2</span>
                    </div> */}
                    <div className="unit-card-details-item flex flex-col gap-2 shrink-0 min-w-[120px]">
                        {currancyIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">{t("unit_details.price")}</span>
                        <span className="unit-card-details-item-value flex items-center gap-1 font-[500]">
                            {" "}
                            {formatNumber(data?.price)} {lang === "ar" ? "ريال" : "SAR"}
                        </span>
                    </div>
                </div>
            </div>
        </Link>
    ) : (
        <div  className="unit-card p-4 rounded-3xl bg-white">
            <div className="unit-card-image relative h-80 overflow-hidden rounded-2xl">
                <ParallaxImage alt={data?.name} src={data?.image || "/images/banner.png"} />
                {showProjectLabel && <div className="unit-card-image-label rounded-full bg-primary text-white py-2 px-4 absolute z-[1] top-4 left-4 shadow-md">{data?.name}</div>}
                {/* <div className="unit-card-image-labels absolute z-[1] top-4 px-4 flex items-center gap-2">
                    <div className="label px-4 bg-primary text-white rounded-full py-2 uppercase text-sm flex items-center h-[3rem]">{t("btn_text.sold_out")}</div>
                    <GeneralButton icon={pdfIcon} isBlack />
                </div> */}
            </div>
            <div className="unit-card-content relative mt-10">
                <h3 className="text-3xl uppercase mb-4">{data?.name}</h3>
                <p className="line-clamp-2" dangerouslySetInnerHTML={{ __html: data?.description }}></p>
            </div>
            <div className="unit-card-details relative mt-6">
                <div className="unit-card-details-items flex items-center justify-between gap-8  p-4 flex-nowrap overflow-x-auto">
                    {/* <div className={clsx("unit-card-details-item flex flex-col gap-2 shrink-0 border-r border-gray pr-4 min-w-[120px]", {
                        "!pr-0 ps-4 !border-r-0 border-l": lang === "ar"
                    })}>
                        {areaIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">Area</span>
                        <span className="unit-card-details-item-value font-[500] flex items-center gap-1">140 - 160 {lang === "ar" ? "م²" : meterSquareIcon }</span>
                    </div>
                    <div className={clsx("unit-card-details-item flex flex-col gap-2 shrink-0 border-r border-gray pr-4 min-w-[120px]", {
                        "!pr-0 ps-4 !border-r-0 border-l": lang === "ar"
                    })}>
                        {bedroomIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">Bedrooms</span>
                        <span className="unit-card-details-item-value font-[500]">2</span>
                    </div> */}
                    <div className="unit-card-details-item flex flex-col gap-2 shrink-0 min-w-[120px]">
                        {currancyIcon}
                        <span className="unit-card-details-item-title text-black/60 uppercase font-[500]">{t("unit_details.price")}</span>
                        <span className="unit-card-details-item-value flex items-center gap-1 font-[500]">
                            {" "}
                            {formatNumber(data?.price)} {lang === "ar" ? "ريال" : "SAR"}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default UnitCard;
