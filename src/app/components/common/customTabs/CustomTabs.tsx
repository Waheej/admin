"use client";
import clsx from "clsx";
import React, { useRef, useEffect } from "react";
import gsap from "gsap";
import GeneralInput from "../generalInput/GeneralInput";
import { useLocale } from "next-intl";
import { IoChevronDown } from "react-icons/io5";

type tabs = {
    label: string;
    value: string;
};

type TCustomTabs = {
    customClass?: string;
    tabsData?: tabs[];
    activeTab?: string;
    setActiveTab?: React.Dispatch<React.SetStateAction<string>>;
    forceSelect?: boolean; // ✅ prop جديدة
};

const CustomTabsComponent: React.FC<TCustomTabs> = ({
    customClass,
    tabsData = [],
    activeTab,
    setActiveTab = () => { },
    forceSelect = false, // ✅ default false
}) => {
    const indicatorRef = useRef<HTMLDivElement>(null);
    const buttonsRef = useRef<(HTMLButtonElement | null)[]>([]);
    const lang = useLocale();

    useEffect(() => {
        if (forceSelect) return; // ✅ لو بنستخدم select ما نعملش أنميشن

        const activeIndex = tabsData.findIndex(
            (tab) => tab.value === activeTab
        );
        const activeButton = buttonsRef.current[activeIndex];

        if (activeButton && indicatorRef.current) {
            const btnRect = activeButton.getBoundingClientRect();
            const parentRect = activeButton.parentElement?.parentElement?.getBoundingClientRect();

            if (parentRect) {
                gsap.to(indicatorRef.current, {
                    x: btnRect.left - parentRect.left,
                    y: btnRect.top - parentRect.top,
                    width: btnRect.width,
                    height: btnRect.height,
                    duration: 0.4,
                    ease: "power3.out",
                });
            }
        }
    }, [activeTab, tabsData, forceSelect]);

    return (
        <div className={clsx("relative w-full md:w-fit text-lg", customClass)}>
            {/* ✅ Desktop Tabs (تظهر فقط لو forceSelect = false) */}
            {!forceSelect && (
                <div className="hidden md:block relative border border-dark/10 rounded-xl px-4.5 py-2.5">
                    <ul className="flex items-center gap-4 w-fit uppercase flex-nowrap relative">
                        <div
                            ref={indicatorRef}
                            className={clsx("absolute bg-dark rounded-lg z-0", {
                                "left-0": lang === "ar",
                            })}
                        />
                        {tabsData.map((tab, index) => (
                            <li key={index}>
                                <button
                                    ref={(el) =>
                                        (buttonsRef.current[index] = el) as any
                                    }
                                    type="button"
                                    className={clsx(
                                        "relative cursor-pointer transition-colors duration-300 text-dark/70 py-2 px-4 uppercase z-[1]",
                                        {
                                            "!text-white": tab.value === activeTab,
                                        }
                                    )}
                                    onClick={() => setActiveTab(tab.value)}
                                >
                                    {tab.label}
                                </button>
                            </li>
                        ))}
                    </ul>
                </div>
            )}

            <div
                className={clsx("w-full min-w-[200px]", {
                    "block": forceSelect,
                    "block md:hidden": !forceSelect,
                })}
            >
                <GeneralInput
                    name="tabs"
                    as="select"
                    value={activeTab}
                    indicatorIcon={<IoChevronDown size={20} />} 
                    indicatorColor="#555" 
                    onChange={(e: React.ChangeEvent<HTMLSelectElement>) =>
                        setActiveTab(e.target.value)
                    }
                    options={tabsData}
                    customClass="bg-white"
                />
            </div>
        </div>
    );
};

// ✅ memoization
const CustomTabs = React.memo(CustomTabsComponent);

export default CustomTabs;
