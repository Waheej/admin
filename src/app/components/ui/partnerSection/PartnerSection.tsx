import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import LogoLoop from "@/app/components/module/logoLoop/LogoLoop";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import React, { useMemo } from "react";
import { SiNextdotjs, SiReact, SiTailwindcss, SiTypescript } from "react-icons/si";

const PartnerSection = ({data}:any) => {
    const imageLogos = [
        { src: "/images/partners/partner1.svg", alt: "Company 1", href: "https://company1.com" },
        { src: "/images/partners/partner2.svg", alt: "Company 2", href: "https://company2.com" },
        { src: "/images/partners/partner3.svg", alt: "Company 3", href: "https://company3.com" },
    ];

    const imagesLogo = useMemo(() => {
        const dataImages = data?.data?.map((data:any) => ({
            src: data?.img,
            alt:data?.name
        }))
        return dataImages
    }, [data])
    
    return (
        <section className="partner-section bg-gray rounded-3xl" data-parallax >
            <GeneralContainer isSection>
                <HeaderSection title={data?.title} customClass="flex justify-center w-full" />
                {data?.data && <LogoLoop
                    logos={imagesLogo}
                    speed={100}
                    direction="left"
                    logoHeight={80}
                    gap={40}
                    pauseOnHover
                    scaleOnHover
                    fadeOut
                    fadeOutColor="var(--color-gray)"
                    ariaLabel="Technology partners"
                />}
                
            </GeneralContainer>
        </section>
    );
};

export default PartnerSection;
