// HeaderSection.tsx
"use client";
import CustomTabs from "@/app/components/common/customTabs/CustomTabs";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import RevealText from "@/app/components/module/revealText/RevealText";
import clsx from "clsx";
import React from "react";
import { GoArrowUpRight } from "react-icons/go";

type tabs = {
    label: string;
    value: string;
};
type THeaderSection = {
    title?: string;
    sub_title?: string;
    description?: string;
    second_desc?: string;
    showSwiperIcon?: boolean;
    customClass?: string;
    showBtn?: boolean;
    btnTitle?: string;
    btnUrl?: string;
    showTabs?: boolean;
    tabsData?: tabs[];
    activeTab?: string;
    setActiveTab?: React.Dispatch<React.SetStateAction<string>>;
    forceSelect?: boolean;
};

const HeaderSection: React.FC<THeaderSection> = React.memo(({ title, sub_title, description, customClass, showBtn, btnTitle, btnUrl, showTabs, tabsData = [], activeTab, setActiveTab, forceSelect }) => {
    return (
        <div className={clsx("header-section mb-16", customClass)}>
            <div className="flex items-center justify-between gap-4 flex-wrap">
                <div
                    className={clsx("header-section-header xl:max-w-[40%] lg:max-w-[40%] md:max-w-[50%] max-w-full shrink-0", {
                        "!max-w-full ": !description && !sub_title,
                    })}>
                    {sub_title && (
                        <div className="overflow-hidden">
                            <p className="text-sm uppercase text-primary mb-2 tracking-wider font-medium">{sub_title}</p>
                        </div>
                    )}
                    <RevealText>
                        <div className="overflow-hidden">
                            <h2 className="text-4xl uppercase reveal-ele">{title}</h2>
                        </div>
                    </RevealText>
                    {description && (
                        <RevealText>
                            <div className="overflow-hidden">
                                <p className="mt-4 reveal-ele xl:text-xl" dangerouslySetInnerHTML={{ __html: description }}></p>
                            </div>
                        </RevealText>
                    )}
                </div>
                {showBtn && <GeneralButton title={btnTitle} isBlack icon={<GoArrowUpRight size={20} />} isFlip isPillEffect url={btnUrl} />}
                {showTabs && <CustomTabs tabsData={tabsData} activeTab={activeTab} setActiveTab={setActiveTab} forceSelect={forceSelect} />}
            </div>
        </div>
    );
});

export default HeaderSection;
