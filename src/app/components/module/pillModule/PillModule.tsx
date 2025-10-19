"use client";
import React, { useEffect, useRef, useState } from "react";
import { gsap } from "gsap";

interface PillEffectProps {
    children: React.ReactNode;
    ease?: string;
}

const PillEffect: React.FC<PillEffectProps> = ({ children, ease = "power3.out" }) => {
    const tlRef = useRef<gsap.core.Timeline | null>(null);
    const labelRef = useRef<HTMLSpanElement | null>(null);
    const hoverRef = useRef<HTMLSpanElement | null>(null);
    const [isTouchDevice, setIsTouchDevice] = useState(false);

    useEffect(() => {
        setIsTouchDevice('ontouchstart' in window || navigator.maxTouchPoints > 0);

        const label = labelRef.current;
        const hover = hoverRef.current;
        if (!label || !hover) return;

        gsap.set(label, { y: 0 });
        gsap.set(hover, { y: "100%", opacity: 0 });

        const tl = gsap.timeline({ paused: true });
        tl.to(label, { y: "-100%", duration: 0.4, ease }, 0);
        tl.to(hover, { y: "0%", opacity: 1, duration: 0.4, ease }, 0);

        tlRef.current = tl;
    }, [ease]);

    const handleEnter = () => {
        if (!isTouchDevice) tlRef.current?.play();
    };
    const handleLeave = () => {
        if (!isTouchDevice) tlRef.current?.reverse();
    };

    return (
        <span
            className="w-fit"
            onMouseEnter={handleEnter}
            onMouseLeave={handleLeave}
            style={{
                position: "relative",
                display: "flex",
                overflow: "hidden",
            }}
        >
            <span ref={labelRef} style={{ display: "block" }}>
                {children}
            </span>
            <span
                ref={hoverRef}
                style={{
                    position: "absolute",
                    left: 0,
                    top: 0,
                    display: "block",
                }}
            >
                {children}
            </span>
        </span>
    );
};

export default PillEffect;
