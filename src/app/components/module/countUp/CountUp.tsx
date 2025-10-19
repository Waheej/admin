"use client";

import { useEffect, useRef } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

interface CountUpProps {
    to: number;
    from?: number;
    delay?: number;
    duration?: number;
    className?: string;
    startWhen?: boolean; // start on in-view
    separator?: string;
    onStart?: () => void;
    onEnd?: () => void;
    title?: string
}

export default function CountUp({
    to,
    from = 0,
    delay = 0,
    duration = 2,
    className = "",
    startWhen = true,
    separator = "",
    onStart,
    onEnd,
    title
}: CountUpProps) {
    const ref = useRef<HTMLSpanElement>(null);

    const getDecimalPlaces = (num: number): number => {
        const str = num.toString();
        if (str.includes(".")) {
            const decimals = str.split(".")[1];
            if (parseInt(decimals) !== 0) return decimals.length;
        }
        return 0;
    };

    const maxDecimals = Math.max(getDecimalPlaces(from), getDecimalPlaces(to));

    useEffect(() => {
        if (!ref.current) return;

        const animate = () => {
            if (typeof onStart === "function") onStart();

            gsap.to(ref.current!, {
                innerText: to,
                duration,
                delay,
                ease: "power3.out",
                snap: { innerText: 1 / Math.pow(10, maxDecimals) }, // للتعامل مع decimals
                onUpdate: function () {
                    const val = parseFloat(ref.current!.innerText);
                    const options: Intl.NumberFormatOptions = {
                        useGrouping: !!separator,
                        minimumFractionDigits: maxDecimals,
                        maximumFractionDigits: maxDecimals,
                    };
                    ref.current!.textContent = separator
                        ? Intl.NumberFormat("en-US", options)
                            .format(val)
                            .replace(/,/g, separator)
                        : Intl.NumberFormat("en-US", options).format(val);
                },
                onComplete: () => {
                    if (typeof onEnd === "function") onEnd();
                },
            });
        };

        if (startWhen) {
            ScrollTrigger.create({
                trigger: ref.current,
                start: "top bottom",
                once: true,
                onEnter: animate,
            });
        } else {
            animate();
        }
    }, [to, from, delay, duration, startWhen, separator, onStart, onEnd, maxDecimals]);

    return <span className={className} ref={ref}>
        <span className="text-5xl mb-1">{from}</span>
        <h2 className="opacity-80 uppercase">{title }</h2>
    </span>;
}
