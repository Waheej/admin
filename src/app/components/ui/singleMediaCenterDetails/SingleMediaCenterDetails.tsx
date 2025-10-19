"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { FaFacebookF, FaLinkedinIn } from "react-icons/fa";
import { FacebookShareButton, LinkedinShareButton, TwitterShareButton } from "react-share";
import React, { useRef } from "react";
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

gsap.registerPlugin(ScrollTrigger);

const SingleMediaCenterDetails = () => {
    const sectionRef = useRef<HTMLDivElement | null>(null);
    const stickyRef = useRef<HTMLDivElement | null>(null);

    // useGSAP(() => {
    //     if (stickyRef.current && sectionRef.current) {
    //         ScrollTrigger.matchMedia({
    //             "(min-width: 1024px)": () => {
    //                 ScrollTrigger.create({
    //                     trigger: sectionRef.current,
    //                     start: "top top",
    //                     end: "bottom bottom",
    //                     pin: stickyRef.current,
    //                     pinSpacing: false,
    //                 });
    //             },
    //             // موبايل/تابلت -> ما يعملش pin
    //             "(max-width: 1023px)": () => {
    //                 if (ScrollTrigger.getById("stickyIcons")) {
    //                     ScrollTrigger.getById("stickyIcons")?.kill();
    //                 }
    //             },
    //         });
    //     }
    // }, []);

    return (
        <section className="single-media-center-details" ref={sectionRef}>
            <GeneralContainer isSection customClass="bg-gray rounded-3xl mb-8">
                <div className="single-media-center-details-icons-container mb-8 w-fit me-auto" ref={stickyRef}>
                    <span className="text-lg uppercase">Share:</span>
                    <div className="single-media-center-details-icons flex justify-end  gap-4 mt-2">
                        <FacebookShareButton url="">
                            <GeneralButton icon={<FaFacebookF size={20} />} customClass="border border-black/10" />
                        </FacebookShareButton>
                        <LinkedinShareButton url="">
                            <GeneralButton icon={<FaLinkedinIn size={20} />} customClass="border border-black/10" />
                        </LinkedinShareButton>
                        <TwitterShareButton url="">
                            <GeneralButton icon={<FaXTwitter size={20} />} customClass="border border-black/10" />
                        </TwitterShareButton>
                        <GeneralButton icon={copyIcon} customClass="border border-black/10" />

                    </div>
                </div>
                <div className="single-media-center-details-content flex flex-col gap-10">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa ipsam sequi explicabo porro, alias odit, deserunt molestias optio, consectetur iusto nam obcaecati beatae! Sequi
                        esse nam non consectetur dolorem dicta necessitatibus quaerat tempore, expedita minima quo voluptatibus quis id? Quam aperiam animi nesciunt ullam similique labore quia
                        cupiditate veniam, ut totam, distinctio numquam qui accusantium eius quod, nulla mollitia quibusdam. Tenetur possimus sed dolore labore dicta natus rerum soluta eum fuga
                        quibusdam, modi quas animi facilis, aliquam ad totam quidem odio. Repudiandae quos molestias eveniet dolor nulla nesciunt voluptatibus obcaecati unde voluptates quis quas
                        quisquam beatae voluptatem facilis laudantium, animi dolore dignissimos voluptate placeat! Culpa nisi eligendi sed. Autem aspernatur, asperiores ad modi enim reiciendis,
                        commodi assumenda atque dicta dolor quo possimus tenetur architecto! Incidunt, vero assumenda obcaecati quae non hic? Et, dolore? Quo veritatis quod temporibus tempora
                        voluptate possimus culpa earum eaque totam, impedit doloremque quia voluptatum libero maxime?
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa ipsam sequi explicabo porro, alias odit, deserunt molestias optio, consectetur iusto nam obcaecati beatae! Sequi
                        esse nam non consectetur dolorem dicta necessitatibus quaerat tempore, expedita minima quo voluptatibus quis id? Quam aperiam animi nesciunt ullam similique labore quia
                        cupiditate veniam, ut totam, distinctio numquam qui accusantium eius quod, nulla mollitia quibusdam. Tenetur possimus sed dolore labore dicta natus rerum soluta eum fuga
                        quibusdam, modi quas animi facilis, aliquam ad totam quidem odio. Repudiandae quos molestias eveniet dolor nulla nesciunt voluptatibus obcaecati unde voluptates quis quas
                        quisquam beatae voluptatem facilis laudantium, animi dolore dignissimos voluptate placeat! Culpa nisi eligendi sed. Autem aspernatur, asperiores ad modi enim reiciendis,
                        commodi assumenda atque dicta dolor quo possimus tenetur architecto! Incidunt, vero assumenda obcaecati quae non hic? Et, dolore? Quo veritatis quod temporibus tempora
                        voluptate possimus culpa earum eaque totam, impedit doloremque quia voluptatum libero maxime?
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa ipsam sequi explicabo porro, alias odit, deserunt molestias optio, consectetur iusto nam obcaecati beatae! Sequi
                        esse nam non consectetur dolorem dicta necessitatibus quaerat tempore, expedita minima quo voluptatibus quis id? Quam aperiam animi nesciunt ullam similique labore quia
                        cupiditate veniam, ut totam, distinctio numquam qui accusantium eius quod, nulla mollitia quibusdam. Tenetur possimus sed dolore labore dicta natus rerum soluta eum fuga
                        quibusdam, modi quas animi facilis, aliquam ad totam quidem odio. Repudiandae quos molestias eveniet dolor nulla nesciunt voluptatibus obcaecati unde voluptates quis quas
                        quisquam beatae voluptatem facilis laudantium, animi dolore dignissimos voluptate placeat! Culpa nisi eligendi sed. Autem aspernatur, asperiores ad modi enim reiciendis,
                        commodi assumenda atque dicta dolor quo possimus tenetur architecto! Incidunt, vero assumenda obcaecati quae non hic? Et, dolore? Quo veritatis quod temporibus tempora
                        voluptate possimus culpa earum eaque totam, impedit doloremque quia voluptatum libero maxime?
                    </p>
                </div>
            </GeneralContainer>
            <GeneralContainer isSection customClass="bg-isabelline rounded-3xl">
                <HeaderSection title="Media Gellery" sub_title="Gellery" />
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
