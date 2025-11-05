"use client";
import CountUp from "@/app/components/module/countUp/CountUp";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useLocale } from "next-intl";
import Image from "next/image";
import React from "react";

gsap.registerPlugin(ScrollTrigger);

const AboutSection = ({data}:any) => {
    const ref = React.useRef<HTMLDivElement>(null);

    const lang = useLocale()

    useGSAP(
        () => {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: ref.current,
                    start: "top top",
                    end: "+=200%",
                    scrub: 1,
                    pin: true,
                    pinSpacing: true, 
                    anticipatePin: 1,
                },

            });

            tl.to(".about-section-image", { width: "100%", height: "100%", duration: 1 });

            tl.fromTo(
                ".about-section-image-overlay",
                { opacity: 0 },
                { opacity: 1, duration: 1 },
                "-=0.5",
            );

            tl.fromTo(
                ".about-section-image-overlay-header .reveal-ele, .about-section-image-overlay-desc .reveal-ele , .about-section-image-overlay-results .reveal-ele",
                { opacity: 0, y: 50 },
                { opacity: 1, y: 0, duration: 1, stagger: 0.3 },
                "-=0.2",
            );

            let countersPlayed = false;

            tl.add(() => {
                if (countersPlayed) return;
                countersPlayed = true;

                const counters = document.querySelectorAll(".countup-ele") as NodeListOf<HTMLElement>;
                counters.forEach((el) => {
                    const endValue = Number(el.dataset.from) || 1000;
                    let current = 0;
                    const step = Math.ceil(endValue / 100);

                    const interval = setInterval(() => {
                        current += step;
                        if (current >= endValue) {
                            current = endValue;
                            clearInterval(interval);
                        }
                        el.innerText = current.toLocaleString();
                    }, 20);
                });
            });

        },
        { scope: ref },
    );

    return (
        <section  ref={ref} className="about-section bg-white h-screen flex items-center justify-center  overflow-hidden">
            <div className="about-section-image w-1/2 h-[40vh] relative rounded-3xl overflow-hidden">
                <Image src={data?.media?.[0] || "/images/about_section.png"} alt="About" fill sizes="(max-width: 768px) 100vw, 50vw" />
                <div className="about-section-image-overlay absolute inset-0 top-0 left-0 bg-black/50 w-full h-full">
                    <GeneralContainer isSection customClass=" flex flex-col justify-between h-full">
                        <div className="about-section-image-overlay-header text-white">
                            <div className="overflow-hidden">
                                <h2 className="text-4xl uppercase reveal-ele">{data?.title }</h2>
                            </div>
                        </div>

                        <div className="about-section-image-overlay-desc text-white/80 text-2xl xl:max-w-1/2 lg:max-w-1/2 md:max-w-1/2 max-w-full overflow-hidden">
                            <p className="reveal-ele" dangerouslySetInnerHTML={{ __html: data?.description }}></p>
                        </div>
                        <div className="about-section-image-overlay-results grid xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-8 text-white text-center">
                            {data?.data?.map((data:any , idx:any) => (
                                <div className="overflow-hidden" key={idx}>
                                    <div className="reveal-ele">
                                        <span className="countup-ele text-5xl" data-from={data?.value}>
                                            0
                                        </span>
                                        <h2 className="text-2xl uppercase">{`${lang == "en" ? data?.label_en : data?.label_ar}`}</h2>
                                    </div>
                                </div>
                            ))}
                        </div>

                    </GeneralContainer>
                </div>
            </div>
        </section>
    );
};

export default AboutSection;
