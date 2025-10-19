"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import { useGSAP } from "@gsap/react";
import clsx from "clsx";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import React, { useEffect, useState } from "react";
import { GoArrowUpRight } from "react-icons/go";
import { MdOutlineArrowDownward } from "react-icons/md";
import { VscSettings } from "react-icons/vsc";

type TFilterTabs = {
    customClass?: string;
    btnUrl?: string;
    btnText?:string
};

gsap.registerPlugin(useGSAP, ScrollTrigger);

const FilterTabs: React.FC<TFilterTabs> = ({ customClass, btnUrl, btnText }) => {
    const containerRef = React.useRef<HTMLDivElement>(null);
    const [fontsLoaded, setFontsLoaded] = useState(false);

    // نتاكد ان الفونتس اتحملت
    useEffect(() => {
        if (document.fonts.status === "loaded") {
            setFontsLoaded(true);
        } else {
            document.fonts.ready.then(() => setFontsLoaded(true));
        }
    }, []);

    useGSAP(
        () => {
            if (!containerRef.current) return;

            const btns = containerRef.current.querySelectorAll(".filter-btn");

            gsap.fromTo(
                btns,
                { scale: 0.5, opacity: 0 },
                {
                    scale: 1,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1, // كل زر يتأخر شوية
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: containerRef.current,
                        start: "top 90%", // يشتغل لما نوصل للعنصر
                        toggleActions: "play none none none",
                        once: true,
                        markers: false, // خليه true لو عايز تختبر
                    },
                }
            );
        },
        { scope: containerRef, dependencies: [fontsLoaded] } 
    );

    return (
        <div
            ref={containerRef}
            className={clsx(
                "filter-tabs py-4 border-b border-black/10  flex items-center justify-between gap-4 ",
                customClass
            )}
        >
            <GeneralButton
                title="filter"
                icon={<VscSettings size={20} />}
                isFlip
                isGray
                customClass="filter-btn "
                isPillEffect
                
            />

            {/* <div className="filter-tabs-sort xl:grid lg:grid md:grid hidden grid-cols-3 gap-4">
                <GeneralButton
                    title="buy"
                    icon={<MdOutlineArrowDownward size={20} />}
                    isFlip
                    isGray
                    customClass="w-full filter-btn"
                />
                <GeneralButton
                    title="any property"
                    icon={<MdOutlineArrowDownward size={20} />}
                    isFlip
                    isGray
                    customClass="w-full filter-btn"
                />
                <GeneralButton
                    title="all area"
                    icon={<MdOutlineArrowDownward size={20} />}
                    isFlip
                    isGray
                    customClass="w-full filter-btn"
                />
            </div> */}

            <GeneralButton title={btnText} isBlack customClass="filter-btn bg-primary text-white" icon={<GoArrowUpRight size={20} />} isFlip isPillEffect url={btnUrl} />
        </div>
    );
};

export default FilterTabs;
