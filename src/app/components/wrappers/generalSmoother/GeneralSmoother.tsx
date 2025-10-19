"use client";
import React, { useEffect } from "react";
import { ReactLenis, useLenis } from "lenis/react";
import { useLenisStore } from "@/app/store/useLenisStore";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { usePathname } from "next/navigation";

gsap.registerPlugin(ScrollTrigger);

type TGeneralSmoother = {
    children: React.ReactNode;
};

const GeneralSmoother: React.FC<TGeneralSmoother> = ({ children }) => {
    const lenis = useLenis();
    const setLenis = useLenisStore((state) => state.setLenis);
    const pathname = usePathname();
    useEffect(() => {
        if (!lenis) return;
        setLenis(lenis);

        lenis.on("scroll", ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
        ScrollTrigger.refresh();

        return () => {
            gsap.ticker.remove((time) => lenis.raf(time * 1000));
        };
    }, [lenis, setLenis]);

    // ✅ لما تتغير الصفحة
    useEffect(() => {
        ScrollTrigger.clearScrollMemory?.();
        ScrollTrigger.refresh();
        lenis?.scrollTo(0, { immediate: true });
        const timeout = setTimeout(() => ScrollTrigger.refresh(), 300);
        return () => clearTimeout(timeout);
    }, [pathname, lenis]);

    // 🎨 Parallax subtle على المحتوى الأبيض
    // useEffect(() => {
    //     const sections = gsap.utils.toArray<HTMLElement>("[data-parallax]");

    //     sections.forEach((el, i) => {
    //         gsap.set(el, { yPercent: 0 }); 

    //         gsap.to(el, {
    //             y: - window.innerHeight * 0.05,
    //             ease: "none",
    //             scrollTrigger: {
    //                 trigger: el,
    //                 start: "top bottom",
    //                 end: "bottom top",
    //                 scrub: true,
    //             },
    //         });
    //     });

    //     ScrollTrigger.refresh();
    // }, []);


    return (
        <ReactLenis
            root
            options={{
                lerp: 0.1, // ✅ زودت شوية عشان يبقى أسرع وأقل تهنيج
                duration: 1.5, // ✅ قللت الـ duration
                smoothWheel: true,
                wheelMultiplier: 1,
                touchMultiplier: 2,
            }}
        >
            <main className="relative bg-white text-black">
                {children}
            </main>
        </ReactLenis>
    );
};

export default GeneralSmoother;
