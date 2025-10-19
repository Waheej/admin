"use client";
import React, { useRef, useEffect } from "react";
import gsap from "gsap";
import { useLoadingRoutePage } from "@/app/store/useLoadingRoutePage";
import useToggleMenu from "@/app/store/useToggleMenu";

const LoadingRoutePage: React.FC = () => {
    const containerRef = useRef<HTMLDivElement | null>(null);
    const whiteLayerRef = useRef<HTMLDivElement | null>(null);
    const darkLayerRef = useRef<HTMLDivElement | null>(null);
    const counterRef = useRef<HTMLSpanElement | null>(null);

    const { isTransitioning, exitRequested, resolveEntry, finishTransition } = useLoadingRoutePage();
    const { closeMenu } = useToggleMenu();

    const hasTransitioned = useRef(false); 

    // Show only during route transitions (avoid showing on refresh/first load)
    useEffect(() => {
        if (!isTransitioning) {
            hasTransitioned.current = false;
        }
    }, [isTransitioning]);

    useEffect(() => {
        if (!whiteLayerRef.current || !darkLayerRef.current || !containerRef.current) return;
        gsap.set([whiteLayerRef.current, darkLayerRef.current], { clipPath: "ellipse(100% 0% at 50% 100%)", visibility: "visible" });
        gsap.set(containerRef.current, { visibility: "hidden", pointerEvents: "none", opacity: 0 });
        if (counterRef.current) gsap.set(counterRef.current, { opacity: 0 });
    }, []);

    useEffect(() => {
        if (!isTransitioning || hasTransitioned.current) return;
        hasTransitioned.current = true;

        if (!whiteLayerRef.current || !darkLayerRef.current || !containerRef.current || !counterRef.current) return;

        // Re-apply initial visual state to guarantee identical entry shape when mounted only during transitions
        gsap.set([whiteLayerRef.current, darkLayerRef.current], { clipPath: "ellipse(100% 0% at 50% 100%)", visibility: "visible" });
        gsap.set(containerRef.current, { visibility: "hidden", pointerEvents: "none", opacity: 0 });
        gsap.set(counterRef.current, { opacity: 0 });

        closeMenu();

        const tl = gsap.timeline({
            onStart: () => {
                gsap.set(containerRef.current, { visibility: "visible", pointerEvents: "auto" });
                gsap.to(containerRef.current, { opacity: 1, duration: 0.2 });
                gsap.set(counterRef.current, { opacity: 0 });
            },
        });

        tl.to(whiteLayerRef.current, { clipPath: "ellipse(120% 120% at 50% 98%)", duration: 1, ease: "power3.inOut" })
            .to(darkLayerRef.current, { clipPath: "ellipse(120% 120% at 50% 98%)", duration: 1, ease: "power3.inOut" }, "-=0.4")
            .add(() => {
                const counterObj = { val: 0 };
                gsap.to(counterObj, {
                    val: 100,
                    duration: 3,
                    ease: "linear",
                    onUpdate() {
                        if (counterRef.current) counterRef.current.textContent = Math.round(counterObj.val) + "%";
                    },
                    onComplete() {
                        resolveEntry();
                    },
                });
                gsap.to(counterRef.current, { opacity: 1, duration: 0.3 });
            });

        return () => { tl.kill(); };
    }, [isTransitioning, resolveEntry, closeMenu]);

    // خروج الصفحة
    useEffect(() => {
        if (!exitRequested) return;
        if (!whiteLayerRef.current || !darkLayerRef.current || !containerRef.current || !counterRef.current) return;

        closeMenu();

        gsap.killTweensOf([whiteLayerRef.current, darkLayerRef.current, containerRef.current, counterRef.current]);

        const exitTl = gsap.timeline({
            onComplete: () => {
                finishTransition();
                gsap.set(containerRef.current, { visibility: "hidden", pointerEvents: "none", opacity: 0 });
            },
        });

        exitTl.to(counterRef.current, { opacity: 0, duration: 0.3 })
            .to(darkLayerRef.current, { clipPath: "ellipse(100% 0% at 50% 100%)", duration: 1, ease: "power3.inOut" })
            .to(whiteLayerRef.current, { clipPath: "ellipse(100% 0% at 50% 100%)", duration: 1, ease: "power3.inOut" }, "-=0.35");

        return () => { exitTl.kill(); };
    }, [exitRequested, finishTransition]);

    if (!isTransitioning && !exitRequested) return null;

    return (
        <div ref={containerRef} className="fixed inset-0 z-[9999] flex items-center justify-center pointer-events-none">
            <div ref={whiteLayerRef} className="absolute inset-0 bg-white" />
            <div ref={darkLayerRef} className="absolute inset-0 bg-black" />
            <span ref={counterRef} className="relative z-10 text-4xl text-white">0%</span>
        </div>
    );
};

export default LoadingRoutePage;
