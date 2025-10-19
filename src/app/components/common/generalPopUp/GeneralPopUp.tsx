"use client";
import React, { useRef, useEffect, useCallback } from "react";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import gsap from "gsap";
import clsx from "clsx";
import { IoClose } from "react-icons/io5";

const GeneralPopUp: React.FC = () => {
    const { type, component, setChildren } = useGeneralPopUp((state) => state);
    const containerRef = useRef<HTMLDivElement>(null);
    const componentRef = useRef<HTMLDivElement>(null);
    const whiteLayerRef = useRef<HTMLDivElement>(null);
    const darkLayerRef = useRef<HTMLDivElement>(null);
    const tl = useRef<gsap.core.Timeline | null>(null);
    const isClosing = useRef(false);

    // إعداد الانيميشن
    useEffect(() => {
        if (!containerRef.current || !componentRef.current || !whiteLayerRef.current || !darkLayerRef.current) return;

        // البداية: مخفي + layers جاهزة
        gsap.set([whiteLayerRef.current, darkLayerRef.current], {
            clipPath: "ellipse(100% 0% at 50% 100%)",
            visibility: "visible",
        });
        gsap.set(containerRef.current, { visibility: "hidden" });
        gsap.set(componentRef.current, { y: 100, opacity: 0 });
        gsap.set(".general-popup-close", { opacity:0 });

        // الخط الزمني
        tl.current = gsap.timeline({ paused: true, defaults: { ease: "power3.inOut" } });
        tl.current
            .set(containerRef.current, { visibility: "visible" })
            .to(whiteLayerRef.current, { clipPath: "ellipse(100% 120% at 50% 98%)", duration: 1 })
            .to(darkLayerRef.current, { clipPath: "ellipse(100% 120% at 50% 98%)", duration: 1 }, "-=0.35")
            .to(componentRef.current, { y: 0, opacity: 1, duration: 0.6 }, "-=0.3")
            .to(".general-popup-close", { opacity: 1, duration: 0.5 }, "-=0.5");
    }, [component]);

    // تشغيل الانيميشن عند الفتح / الإغلاق
    useEffect(() => {
        if (!tl.current) return;
        if (type && component) {
            isClosing.current = false;
            tl.current.play(0);
        } else if (tl.current && component) {
            if (!isClosing.current) {
                isClosing.current = true;
                tl.current.reverse().eventCallback("onReverseComplete", () => {
                    setChildren(null, "");
                    isClosing.current = false;
                });
            }
        }
    }, [type, component, setChildren]);

    const handleClose = useCallback(() => {
        if (!tl.current || isClosing.current) return;
        isClosing.current = true;
        tl.current.reverse().eventCallback("onReverseComplete", () => {
            setChildren(null, "");
            isClosing.current = false;
        });
    }, [setChildren]);

    if (!component) return null;

    return (
        <div
            ref={containerRef}
            className={clsx("general-popup fixed z-50 w-full h-screen p-4 ", {
                // "backdrop-blur-md": type === "video",
                "flex items-end": type == "unit-details"
            })}
            onMouseDown={(e) => e.target === containerRef.current && handleClose()}
        >
            {/* Layers زي Menu */}
            <div ref={whiteLayerRef} className="absolute inset-0 bg-white z-10" />
            <div ref={darkLayerRef} className="absolute inset-0 bg-black z-20" />

            {/* Component */}
            <div
                ref={componentRef}
                className={clsx("relative z-30 w-full h-full flex items-center justify-center", {
                    "flex items-center justify-center": type === "video",
                    "bg-white !h-[90%] rounded-3xl": type == "unit-details"
                })}
            >
                {component}
            </div>

            {/* Close Button */}
            <div
                onClick={handleClose}
                className="general-popup-close absolute top-4 right-4 w-12 h-12 bg-white flex items-center justify-center rounded-full cursor-pointer z-40"
            >
                <IoClose className="text-2xl text-dark" />
            </div>
        </div>
    );
};

export default GeneralPopUp;
