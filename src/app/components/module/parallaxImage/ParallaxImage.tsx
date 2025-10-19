"use client";
import { useLenis } from "lenis/react";
import Image from "next/image";
import React, { useEffect } from "react";
type TLurp = (start: number, end: number, progress: number) => number;
type TParallaxImage = {
    src: string;
    alt: string;
    customClass?: string;
    priority?: boolean;
    sizes?: string;
};
const lurp: TLurp = (start, end, progress) => start + (end - start) * progress;
const ParallaxImage: React.FC<TParallaxImage> = ({ src, alt, customClass, priority = false, sizes = "(max-width: 768px) 100vw, 50vw" }) => {
    const imageRef = React.useRef<HTMLImageElement>(null);
    const bounds = React.useRef<{ top: number; bottom: number }>(null);
    const currentTranslateY = React.useRef(0);
    const targetTranslateY = React.useRef(0);
    const refId = React.useRef<number | null>(null);

    useEffect(() => {
        const updateBounds = () => {
            if (imageRef.current) {
                const rect = imageRef.current.getBoundingClientRect();
                bounds.current = {
                    top: rect.top + window.scrollY,
                    bottom: rect.bottom + window.scrollY,
                };
            }
        };

        updateBounds();
        window.addEventListener("resize", updateBounds);

        const animate = () => {
            if (imageRef.current) {
                currentTranslateY.current = lurp(currentTranslateY.current, targetTranslateY.current, 0.1);
                if (Math.abs(currentTranslateY.current - targetTranslateY.current) > 0.01) {
                    imageRef.current.style.transform = `translateY(${currentTranslateY.current}px) scale(1.5)`;
                }
            }
            refId.current = requestAnimationFrame(animate);
        };

        animate();

        return () => {
            window.removeEventListener("resize", updateBounds);
            if (refId.current) {
                cancelAnimationFrame(refId.current);
            }
        };
    }, []);

    useLenis(({ scroll }) => {
        if (!bounds.current) return;
        const navigationScroll = scroll - bounds.current.top;
        targetTranslateY.current = navigationScroll * 0.12;
    });

    return <Image src={src} alt={alt} ref={imageRef} fill sizes={sizes} priority={priority} className={`${customClass} object-cover`} style={{ willChange: "transform", transform: "translateY(0) scale(1.5)" }} />;
};

export default ParallaxImage;
