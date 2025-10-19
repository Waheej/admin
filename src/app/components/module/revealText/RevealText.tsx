"use client";
import React, { useEffect, useRef, useState } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { SplitText as GSAPSplitText } from "gsap/SplitText";
import { useLoadingRoutePage } from "@/app/store/useLoadingRoutePage";

gsap.registerPlugin(ScrollTrigger, GSAPSplitText);

type TRevealWrapper = {
    children: React.ReactNode;
    delay?: number;
    duration?: number;
    ease?: string | ((t: number) => number);
    from?: gsap.TweenVars;
    to?: gsap.TweenVars;
    threshold?: number;
    rootMargin?: string;
    onCompleteAll?: () => void;
    stagger?: number;
};

const RevealText: React.FC<TRevealWrapper> = ({
    children,
    delay = 0.05,
    duration = 0.8,
    ease = "power3.out",
    from = { opacity: 0, y: 80, filter: "blur(0px)" },
    to = { opacity: 1, y: 0, filter: "blur(0px)" },
    threshold = 0.1,
    stagger = delay / 1000,
    rootMargin = "-100px",
    onCompleteAll,
}) => {
    const wrapperRef = useRef<HTMLDivElement>(null);
    const [fontsLoaded, setFontsLoaded] = useState(false);
    const isTransitioning = useLoadingRoutePage((s) => s.isTransitioning);

    // ✅ تأكد إن الخطوط جاهزة قبل أي أنيميشن
    useEffect(() => {
        const checkFonts = async () => {
            try {
                // Wait for document to be ready
                if (document.readyState === 'loading') {
                    await new Promise(resolve => {
                        document.addEventListener('DOMContentLoaded', resolve, { once: true });
                    });
                }

                // Wait for fonts to be loaded
                if (document.fonts && document.fonts.ready) {
                    await document.fonts.ready;
                }

                // Additional check: wait for all fonts to be loaded
                if (document.fonts) {
                    // Check if any fonts are still loading
                    const fontFaces = Array.from(document.fonts);
                    const loadingPromises = fontFaces.map(font => {
                        if (font.status === 'loading') {
                            return new Promise(resolve => {
                                // Use font loading events if available
                                if ('addEventListener' in font) {
                                    (font as any).addEventListener('load', resolve, { once: true });
                                    (font as any).addEventListener('error', resolve, { once: true });
                                } else {
                                    // Fallback: just resolve after a short delay
                                    setTimeout(resolve, 50);
                                }
                            });
                        }
                        return Promise.resolve();
                    });
                    
                    await Promise.all(loadingPromises);
                }

                // Small delay to ensure everything is settled
                await new Promise(resolve => setTimeout(resolve, 50));
                
                setFontsLoaded(true);
            } catch (error) {
                // Fallback: set fonts as loaded after a reasonable delay
                setTimeout(() => setFontsLoaded(true), 200);
            }
        };

        checkFonts();
    }, []);

    // ✅ أنيميشن منفصل لكل instance من RevealText
    useEffect(() => {
        if (!wrapperRef.current || !fontsLoaded || isTransitioning) return;

        // Additional delay to ensure DOM is fully settled
        const timeoutId = setTimeout(() => {
            const elements = wrapperRef.current?.querySelectorAll(".reveal-ele");
            if (!elements || elements.length === 0) return;

            const triggers: ScrollTrigger[] = [];

            elements.forEach((el, idx) => {
                // Ensure element is visible and has content
                if (!el.textContent?.trim() || (el as HTMLElement).offsetHeight === 0) return;

                try {
                    const split = new GSAPSplitText(el as HTMLElement, {
                        type: "lines",
                        linesClass: "split-line overflow-hidden",
                    });

                    if (split.lines && split.lines.length > 0) {
                        const tween = gsap.fromTo(
                            split.lines,
                            { ...from },
                            {
                                ...to,
                                duration,
                                ease,
                                stagger,
                                delay: idx * 0.2,
                                scrollTrigger: {
                                    trigger: el,
                                    start: "top 85%",
                                    once: true,
                                },
                                onComplete: () => {
                                    if (idx === elements.length - 1) onCompleteAll?.();
                                },
                            }
                        );

                        if (tween.scrollTrigger) {
                            triggers.push(tween.scrollTrigger);
                        }
                    }
                } catch (error) {
                    // SplitText error handled silently
                }
            });

            // ✅ cleanup لكل سكشن منفصل
            return () => {
                triggers.forEach((trigger) => trigger.kill());
                ScrollTrigger.refresh();
            };
        }, 100);

        return () => clearTimeout(timeoutId);
    }, [children, fontsLoaded, from, to, duration, ease, stagger, onCompleteAll, isTransitioning]);

    return <div ref={wrapperRef} className="reveal-wrapper">{children}</div>;
};

export default RevealText;
