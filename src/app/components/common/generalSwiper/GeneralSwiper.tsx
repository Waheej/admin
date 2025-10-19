"use client";
import React from "react";
import { Swiper } from "swiper/react";
import "swiper/css";
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Autoplay, Pagination } from "swiper/modules";

type Breakpoints = {
    [key: number]: {
        slidesPerView: number;
        spaceBetween?: number;
    };
};
type TGeneralSwiper = {
    children: React.ReactNode;
    breakpoints?: Breakpoints;
    loop?: boolean;
    spaceBetween?: number;
    onSlideChange?: (swiper: any) => void;
    autoplay?: any;
    paginationElement?: string;
};
const GeneralSwiper: React.FC<TGeneralSwiper> = ({ children, breakpoints, spaceBetween, onSlideChange, loop, autoplay, paginationElement }) => {
    return (
        <Swiper
            speed={800}
            
            modules={[Autoplay ,Pagination]}
            breakpoints={breakpoints}
            spaceBetween={spaceBetween}
            onSlideChange={onSlideChange}
            pagination={{ clickable: true, el: paginationElement }}
            loop={loop}
            watchSlidesProgress={true}
            loopPreventsSliding
            parallax
            autoplay={{ ...autoplay, disableOnInteraction: false, waitForTransition: false  ,pauseOnMouseEnter: true}}>
            {children}
        </Swiper>
    );
};

export default GeneralSwiper;
