"use client";
import useToggleMenu from "@/app/store/useToggleMenu";
import clsx from "clsx";
import React, { useLayoutEffect, useRef } from "react";
import { gsap } from "gsap";

const ToggleMenuIcon: React.FC<{ customClass?: string }> = ({ customClass }) => {
    const { isOpen, toggle } = useToggleMenu();

    const line1Ref = useRef<HTMLSpanElement>(null);
    const line2Ref = useRef<HTMLSpanElement>(null);
    const line3Ref = useRef<HTMLSpanElement>(null);
    const tlRef = useRef<gsap.core.Timeline | null>(null);

    useLayoutEffect(() => {
        if (!line1Ref.current ||  !line3Ref.current) return;

        const ctx = gsap.context(() => {
            tlRef.current = gsap.timeline({
                paused: true,
                defaults: { ease: "power3.inOut", duration: 0.4 },
            });

            tlRef.current
                .to(line1Ref.current, { y: 5, rotate: 45 }, 0) // أول خط ينزل ويتلف
                // .to(line2Ref.current, { opacity: 0 }, 0) // الخط الأوسط يختفي
                .to(line3Ref.current, { y: -3, rotate: -45 }, 0); // الخط الأخير يطلع ويتلف
        });

        return () => ctx.revert();
    }, []);

    useLayoutEffect(() => {
        if (!tlRef.current) return;
        if (isOpen) {
            tlRef.current.play();
        } else {
            tlRef.current.reverse();
        }
    }, [isOpen]);

    return (
        <div
            role="button"
            aria-expanded={isOpen}
            onClick={toggle}
            className={clsx(
                "toggle-menu-icon text-dark bg-white !min-h-[3rem] !min-w-[3rem]  flex items-center justify-center rounded-full cursor-pointer relative",
                customClass
            )}
        >
            <div className="relative w-6 gap-1.5 flex flex-col justify-between h-fit">
                <span ref={line1Ref} className="block h-[2px] w-full bg-primary rounded"></span>
                {/* <span ref={line2Ref} className="block h-[1px] w-full bg-primary rounded"></span> */}
                <span ref={line3Ref} className="block h-[2px] w-full bg-primary rounded"></span>
            </div>
        </div>
    );
};

export default ToggleMenuIcon;
