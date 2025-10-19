import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { useTranslations } from "next-intl";
import React, { useEffect, useRef } from "react";

const ThanksMessage = ({ isSuccess }: { isSuccess: boolean }) => {
    const t = useTranslations();
    const containerRef = useRef<HTMLDivElement>(null);
    const tlRef = useRef<gsap.core.Timeline | null>(null);

    useGSAP(() => {
        if (!containerRef.current) return;
        tlRef.current = gsap.timeline({ paused: true });
        const containerChildren = document.querySelectorAll(".thanks-message-container > *");
        tlRef.current
            .fromTo(containerRef.current, { opacity: 0, pointerEvents: "none" }, { opacity: 1, pointerEvents: "auto", duration: 0.6, ease: "power3.out" })
            .fromTo(".thanks-message-container", { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 0.4, ease: "power3.out" }, "-=0.3")
            .fromTo(containerChildren, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.3, ease: "power3.out", stagger: 0.1 }, "-=0.2");
    });

    useEffect(() => {
        if (isSuccess && tlRef.current) {
            tlRef.current.play();
            const timer = setTimeout(() => {
                tlRef.current?.reverse();
            }, 2000);

            return () => clearTimeout(timer);
        }
    }, [isSuccess]);

    return (
        <div ref={containerRef} className="thanks-message fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/50 z-50 opacity-0 pointer-events-none">
            <div className="thanks-message-container bg-white p-8 rounded-3xl text-center flex flex-col gap-2">
                <h2 className="text-2xl">{t("form.success_title")}</h2>
                <p>{t("form.success_msg")}</p>
            </div>
        </div>
    );
};

export default ThanksMessage;
