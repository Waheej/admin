import GeneralVideo from "@/app/components/common/generalVideo/GeneralVideo";
import clsx from "clsx";
import React from "react";

type TVideoElement = {
    customClass?: string;
    videoSrc: string;
    autoPlay?: boolean;
};
const VideoElement: React.FC<TVideoElement> = ({ customClass, videoSrc }) => {
    return (
        <div className={clsx("video-element rounded-3xl overflow-hidden xl:h-[80%] lg:h-[80%] md:h-[90%] h-full xl:w-[80%] lg:w-[80%] md:w-[90%] w-full m-auto", customClass)}>
            <GeneralVideo src={videoSrc} autoPlay controls  playsInline isPopup/>
        </div>
    );
};

export default VideoElement;
