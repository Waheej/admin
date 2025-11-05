"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { FaFacebookF, FaLinkedinIn } from "react-icons/fa";
import { FacebookShareButton, LinkedinShareButton, TwitterShareButton } from "react-share";
import React, { useRef, useState } from "react";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { FaXTwitter } from "react-icons/fa6";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import GeneralSwiper from "@/app/components/common/generalSwiper/GeneralSwiper";
import { SwiperSlide } from "swiper/react";
import GeneralSwiperPagination from "@/app/components/common/generalSwiperPagination/GeneralSwiperPagination";
import Image from "next/image";
import { copyIcon } from "@/app/data/data";
import { useTranslations } from "next-intl";

gsap.registerPlugin(ScrollTrigger);

const SingleMediaCenterDetails = ({ data }: { data: any }) => {
    const sectionRef = useRef<HTMLDivElement | null>(null);
    const stickyRef = useRef<HTMLDivElement | null>(null);
    const [copied, setCopied] = useState(false);
    const t = useTranslations();
    // الحصول على الـ URL الحالي
    const currentUrl = typeof window !== 'undefined' ? window.location.href : '';
    
    // دالة نسخ الرابط
    const handleCopyLink = async () => {
        try {
            await navigator.clipboard.writeText(currentUrl);
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        } catch (err) {
            console.error('Failed to copy:', err);
        }
    };
    return (
        <section className="single-media-center-details" ref={sectionRef}>
            <GeneralContainer isSection customClass="bg-gray rounded-3xl mb-8">
                <div className="single-media-center-details-icons-container mb-8 w-fit me-auto" ref={stickyRef}>
                    <span className="text-lg uppercase">{ t("common.share") }:</span>
                    <div className="single-media-center-details-icons flex justify-end  gap-4 mt-2">
                        <FacebookShareButton url={currentUrl} title={data?.title}>
                            <GeneralButton icon={<FaFacebookF size={20} />} customClass="border border-black/10" />
                        </FacebookShareButton>
                        <LinkedinShareButton url={currentUrl} title={data?.title}>
                            <GeneralButton icon={<FaLinkedinIn size={20} />} customClass="border border-black/10" />
                        </LinkedinShareButton>
                        <TwitterShareButton url={currentUrl} title={data?.title}>
                            <GeneralButton icon={<FaXTwitter size={20} />} customClass="border border-black/10" />
                        </TwitterShareButton>
                        <GeneralButton 
                            icon={copyIcon} 
                            customClass="border border-black/10" 
                            customClick={handleCopyLink}
                            // title={copied ? "Copied!" : "Copy Link"}
                        />
                    </div>
                </div>
                <div className="single-media-center-details-content flex flex-col gap-10">
                   <p dangerouslySetInnerHTML={{ __html: data?.description }}></p>
                </div>
            </GeneralContainer>
            <GeneralContainer isSection customClass="bg-isabelline rounded-3xl">
                <HeaderSection title={t("gallery.title")} sub_title={t("gallery.subtitle")} />
                <GeneralSwiper
                    spaceBetween={20}
                    paginationElement=".swiper-media-pagination"
                    autoplay={{ delay: 5000, disableOnInteraction: false }}
                    loop
                    breakpoints={{
                        1024: { slidesPerView: 3.5 },
                        768: { slidesPerView: 1 },
                        640: { slidesPerView: 1 },
                    }}>
                    {Array.from({ length: 2 }).map((_, index) => (
                        <SwiperSlide key={index}>
                            <div className="h-80 bg-red-500 relative rounded-3xl overflow-hidden">
                                <Image src={"/images/banner.png"} alt="banner" fill className="object-cover" />
                            </div>
                        </SwiperSlide>
                    ))}
                </GeneralSwiper>
                <GeneralSwiperPagination customClass="swiper-media-pagination" />
            </GeneralContainer>
        </section>
    );
};

export default SingleMediaCenterDetails;
