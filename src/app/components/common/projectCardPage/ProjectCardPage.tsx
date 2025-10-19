import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import clsx from "clsx";
import Image from "next/image";
import React from "react";
import { PiFilePdf } from "react-icons/pi";

type TProjectCardPage = {
    reversed?: boolean;
    data?:any
};

const ProjectCardPage: React.FC<TProjectCardPage> = ({data, reversed = false }) => {
    return (
        <div  className={clsx("project-card-page flex items-center xl:h-[60vh] lg:h-[60vh] h-auto xl:gap-8 lg:gap-8 gap-4 group xl:flex-nowrap lg:flex-nowrap flex-wrap", reversed ? "xl:flex-row-reverse lg:flex-row-reverse  justify-start" : "flex-row justify-between")}>
            <div className={clsx("project-card-page-content xl:py-8 lg:py-8 py-4 xl:w-1/3 lg:w-1/3 w-full flex flex-col justify-between", reversed && "me-auto")}>
                <div className="flex flex-col justify-between gap-8">
                    <div className="project-card-page-content-location flex items-center gap-2 reveal-ele">
                        <Image src={ "/images/location.png"} alt={"location"} width={40} height={40} />
                        <span className="text-xl">{data?.city }</span>
                    </div>
                    <div className="project-card-page-content-title overflow-hidden">
                        <h2 className="text-4xl uppercase reveal-ele">{data?.name }</h2>
                    </div>
                    <div className="project-card-page-content-desc overflow-hidden">
                        <p className="text-lg uppercase text-gray-400 reveal-ele" dangerouslySetInnerHTML={{ __html: data?.description }}></p>
                    </div>
                    <GeneralButton title="learn more" isBlack isPillEffect customClass="reveal-ele" url={`/projects/${data?.id}`}/>
                </div>
            </div>
            <div className="project-card-page-image xl:h-full lg:h-full h-80 relative xl:w-1/2 lg:w-1/2 w-full rounded-3xl overflow-hidden shrink-0 border border-black/10">
                <ParallaxImage src={data?.image ? data?.image :"/images/banner.png"} alt="" customClass="project-card-page-image-img" />
                {/* <Image src={"/images/banner.png"} fill alt="" /> */}

                {/* <div className="project-card-page-image-content absolute top-0 left-0 inset-0 w-full h-full flex items-end xl:p-6 lg:p-6 p-4 bg-linear-to-bs from-black/20 to-black/50 to-85%">
                    <div className="project-card-page-image-content-button flex items-strach gap-2 xl:translate-y-40 lg:translate-y-40 duration-300 transition-transform group-hover:translate-y-0">
                        <div className="project-card-page-image-content-button-logo bg-dark flex items-center justify-center w-30 rounded-lg">
                            <Image src={"/images/logo/logo-rect-light.svg"} width={80} height={80} alt="" style={{ width: "auto", height: "auto" }} />
                        </div>
                        <GeneralButton isBlack icon={<PiFilePdf size={25} />} />
                    </div>
                </div> */}
            </div>
        </div>
    );
};

export default ProjectCardPage;
