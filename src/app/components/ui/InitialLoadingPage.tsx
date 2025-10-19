"use client";
import React, { useEffect, useRef } from "react";
import gsap from "gsap";
import { useInitialLoader } from "@/app/store/useInitialLoader";
import { useTranslations } from "next-intl";

const InitialLoadingPage: React.FC = () => {
    const t = useTranslations()
    const containerRef = useRef<HTMLDivElement | null>(null);
    const whiteLayerRef = useRef<HTMLDivElement | null>(null);
    const blackLayerRef = useRef<HTMLDivElement | null>(null);
    const logoWrapperRef = useRef<HTMLDivElement | null>(null);
    const logoImgRef = useRef<HTMLImageElement | null>(null);
    const loadingTextRef = useRef<HTMLSpanElement | null>(null);
    const counterRef = useRef<HTMLSpanElement | null>(null);

    const { visible, progress, setProgress, hide } = useInitialLoader();

    useEffect(() => {
        if (!containerRef.current || !whiteLayerRef.current || !blackLayerRef.current) return;
        gsap.set(containerRef.current, { visibility: "hidden", opacity: 0, pointerEvents: "none" });
        gsap.set(logoWrapperRef.current, { y: -100, opacity: 0 });
        gsap.set(".logo-text", { y: -100, opacity: 0 });
        gsap.set([whiteLayerRef.current, blackLayerRef.current], {
            clipPath: "ellipse(120% 120% at 50% 98%)",
            visibility: "visible",
        });
    }, []);

    useEffect(() => {
        if (!visible) return;
        if (!containerRef.current || !whiteLayerRef.current || !blackLayerRef.current) return;

        const tl = gsap.timeline({
            onStart: () => {
                gsap.set(containerRef.current, {
                    visibility: "visible",
                    opacity: 1,
                    pointerEvents: "auto",
                });
            },
        });
        tl.fromTo([logoWrapperRef.current, ".logo-text"], { y: -100, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: "power3.out", stagger: 0.15 });

        const counterObj = { val: progress || 0 };
        gsap.to(counterObj, {
            val: 100,
            duration: 2,
            ease: "linear",
            onUpdate: () => {
                const current = Math.round(counterObj.val);
                setProgress(current);
                if (counterRef.current) counterRef.current.textContent = current + "%";
            },
            onComplete: () => {
                // خروج العناصر لفوق
                const exit = gsap.timeline({
                    onComplete: () => hide(),
                });
                exit.to([logoWrapperRef.current, ".logo-text"], { y: -100, opacity: 0, duration: 0.6, ease: "power2.in", stagger: 0.1 })
                .to(blackLayerRef.current, { clipPath: "ellipse(100% 0% at 50% 100%)", duration: 1, ease: "power3.inOut" })
                .to(whiteLayerRef.current, { clipPath: "ellipse(100% 0% at 50% 100%)", duration: 1, ease: "power3.inOut" }, "-=0.3")
                .to(containerRef.current, { opacity: 0, duration: 0.2 }, "-=0.2");
            },
        });

        return () => {
            tl.kill();
            gsap.killTweensOf(counterObj);
        };
    }, [visible, setProgress, hide]);

    if (!visible) return null;

    return (
        <div ref={containerRef} className="fixed inset-0 z-[10000] flex items-center justify-center ">
            <div ref={whiteLayerRef} className="absolute inset-0 bg-isabelline" />
            <div ref={blackLayerRef} className="absolute inset-0 bg-black" />

            <div className="relative z-10 flex flex-col items-center gap-4 text-white">
                {/* اللوجو */}
                <div className="overflow-hidden">
                    <div ref={logoWrapperRef}>
                        <img ref={logoImgRef} src="/images/logo/logo-rect-light.svg" alt="Waheej logo" className="w-[200px] h-auto" />
                    </div>
                </div>

                {/* Loading + counter */}
                <div className=" overflow-hidden">
                    <div className="logo-text flex items-end gap-3">
                        <span ref={loadingTextRef} className="uppercase tracking-[0.3em] text-sm opacity-90 inline-block">
                            {t("common.loading")}
                        </span>
                        <span ref={counterRef} className="text-sm font-mono opacity-80 inline-block">
                            0%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default InitialLoadingPage;
