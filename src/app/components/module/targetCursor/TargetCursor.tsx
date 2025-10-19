"use client";
import React, { useEffect, useRef } from "react";
import { gsap } from "gsap";

const TargetCursor: React.FC = () => {
    const cursorRef = useRef<HTMLDivElement>(null);
    const textRef = useRef<HTMLSpanElement>(null);

    useEffect(() => {
        if (!cursorRef.current) return;
        const originalCursor = document.body.style.cursor;
        // document.body.style.cursor = "none";
        const moveHandler = (e: MouseEvent) => {
            gsap.to(cursorRef.current, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.15,
                ease: "power3.out",
            });
        };
        window.addEventListener("mousemove", moveHandler);

        // لما يدخل على عنصر فيه data-cursor-text
        const enterHandler = (e: MouseEvent) => {
            const target = (e.target as HTMLElement).closest("[data-cursor-text]") as HTMLElement | null;
            if (!target || !cursorRef.current) return;

            const cursorText = target.getAttribute("data-cursor-text");
            if (cursorText) {
                if (textRef.current) textRef.current.innerText = cursorText;

                gsap.to(cursorRef.current, {
                    width: "100px",
                    height: "50px",
                    duration: 0.3,
                    ease: "power3.out",
                });
            }
        };

        // لما يسيب العنصر
        const leaveHandler = (e: MouseEvent) => {
            if (textRef.current) textRef.current.innerText = "";
            gsap.to(cursorRef.current, {
                width: "10px",
                height: "10px",
                duration: 0.3,
                ease: "power3.out",
            });
        };

        window.addEventListener("mouseover", enterHandler);
        window.addEventListener("mouseout", leaveHandler);

        return () => {
            window.removeEventListener("mousemove", moveHandler);
            window.removeEventListener("mouseover", enterHandler);
            window.removeEventListener("mouseout", leaveHandler);
            document.body.style.cursor = originalCursor;
        };
    }, []);

    return (
        <div
            ref={cursorRef}
            className="fixed top-0 left-0 w-0 h-0 bg-primary text-white text-xs flex items-center justify-center rounded-2xl pointer-events-none z-[9999] "
            style={{ willChange: "transform", transform: "translate(-50%, -50%)" }}
        >
            <span ref={textRef} className="pointer-events-none select-none"></span>
        </div>
    );
};

export default TargetCursor;
