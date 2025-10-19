"use client";

import React, { useEffect, useRef, forwardRef, useImperativeHandle } from "react";
import ReactPlayer from "react-player";
import clsx from "clsx";

export type TGeneralVideo = {
    src?: string;
    autoPlay?: boolean;
    muted?: boolean;
    loop?: boolean;
    playsInline?: boolean;
    controls?: boolean;
    customClass?: string;
    ref?: React.RefObject<HTMLDivElement>;
    isPopup?: boolean;
};
const GeneralVideo = forwardRef<HTMLDivElement, TGeneralVideo>((props, ref) => {
    const {
        src,
        autoPlay = false,
        loop = false,
        playsInline = true,
        controls = false,
        customClass,
        isPopup
    } = props;

    const playerRef = useRef<any>(null);
    // Honor explicit autoplay for background, and for popup
    const [isPlaying, setIsPlaying] = React.useState(autoPlay);

    useImperativeHandle(ref, () => playerRef.current);

    const handlePlay = () => {
        setIsPlaying(true);
    };

    return (
        <div className={clsx("general-video w-full h-full  overflow-hidden", customClass)}>
            <ReactPlayer
                ref={playerRef}
                src={src}
                playing={isPlaying}
                muted={!isPopup}
                loop={loop}
                playsInline={playsInline}
                controls={controls}
                width="100%"
                height="100%"
                className="!object-cover !aspect-video r"
                onPlay={handlePlay}
                onCanPlay={handlePlay}
                // config={{
                //     file: {
                //         attributes: {
                //             preload: "none",
                //             poster: undefined,
                //         },
                //     },
                // }}
            />
        </div>
    );
});

GeneralVideo.displayName = "GeneralVideo";

export default GeneralVideo;
