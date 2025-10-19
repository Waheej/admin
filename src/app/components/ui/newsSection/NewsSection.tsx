"use client";
import React, { useEffect, useRef, useState } from "react";
import { SwiperSlide } from "swiper/react";
import gsap from "gsap";
import GeneralSwiper from "@/app/components/common/generalSwiper/GeneralSwiper";
import HeaderSection from "@/app/components/common/headerSection/HeaderSection";
import NewsCard from "@/app/components/common/newsCard/NewsCard";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import GeneralSwiperPagination from "@/app/components/common/generalSwiperPagination/GeneralSwiperPagination";
import { useLocale, useTranslations } from "next-intl";
import clsx from "clsx";

gsap.registerPlugin();

const NewsSection = ({ data, isProjectNews = false }: { data?: any; isProjectNews?: boolean }) => {
    const [activeIndex, setActiveIndex] = useState(0);
    const [heights, setHeights] = useState<number[]>([]);
    const containerRef = useRef<HTMLDivElement>(null);
    const cardsRef = useRef<Array<HTMLDivElement | null>>([]);
    const [swiperVisible, setSwiperVisible] = useState(false);
    
    // ✅ تحديد البيانات: إما من props.data (project news) أو data?.data (general news)
    const newsData = isProjectNews ? data : data?.data;
    useEffect(() => {
        const arr = Array.from({ length: 6 }, () => Math.floor(Math.random() * (60 - 30 + 1)) + 30);
        setHeights(arr);
    }, []);

    useEffect(() => {
        if (!containerRef.current) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setSwiperVisible(true);
                    observer.disconnect();
                }
            },
            { threshold: 0.1 },
        );
        observer.observe(containerRef.current);
    }, []);

    // useEffect(() => {
    //     if (!swiperVisible || !containerRef.current) return;

    //     const ctx = gsap.context(() => {
    //         const cards = cardsRef.current.filter(Boolean) as HTMLDivElement[];
    //         gsap.fromTo(
    //             cards,
    //             { xPercent: 150,  },
    //             {
    //                 xPercent: 0,
    //                 duration: 1,
    //                 ease: "power3.out",
    //                 stagger: 0.1,
    //             }
    //         );
    //     }, containerRef);

    //     return () => ctx.revert();
    // }, [swiperVisible]);

    // useEffect(() => {
    //     if (!containerRef.current) return;

    //     const ctx = gsap.context(() => {
    //         const img = containerRef.current!.querySelectorAll("img");
    //         img.forEach((card, idx) => {
    //             if (!card) return;

    //             const tl = gsap.timeline({ defaults: { duration: 1, ease: "power3.out", overwrite: "auto", immediateRender: false } });

    //             if (idx === activeIndex) {
    //                 tl.to(card, { filter: "contrast(1) saturate(1)" })
    //             } else {
    //                 tl.to(card, { filter: "contrast(0.5) saturate(0)" })
    //             }
    //         });
    //     }, containerRef);

    //     return () => ctx.revert();
    // }, [activeIndex]);

    const t = useTranslations();
    const lang = useLocale();
    // ✅ عدم العرض إذا لم تكن هناك أخبار
    if (!newsData || newsData.length === 0) return null;

    return (
        <section ref={containerRef} className="news-section" data-parallax>
            <GeneralContainer isSection customClass={clsx("bg-isabelline rounded-3xl")}>
                <HeaderSection 
                    title={isProjectNews ? t("about.project_news_title") : data?.title} 
                    description={isProjectNews ? t("about.project_news_desc") : data?.description} 
                    showBtn={!isProjectNews} 
                    btnTitle={t("btn_text.veiw_all_news")} 
                    btnUrl="/media-center" 
                />
                <div className="news-section-container">
                    <GeneralSwiper
                        paginationElement=".swiper-news-pagination"
                        autoplay={{ delay: 5000, disableOnInteraction: false }}
                        loop={newsData.length > 1}
                        onSlideChange={(swiper) => setActiveIndex(swiper.realIndex)}
                        breakpoints={{
                            1024: { slidesPerView: newsData.length > 1 ? 1.3 : 1 },
                            768: { slidesPerView: 1 },
                            640: { slidesPerView: 1 },
                        }}
                        spaceBetween={20}>
                        {newsData.map((newsItem: any, idx: number) => (
                            <SwiperSlide key={newsItem.id || idx}>
                                <div
                                    ref={(el) => (cardsRef.current[idx] = el) as any}
                                    className="news-card-slide-inner"
                                >
                                    <NewsCard newsData={newsItem} />
                                </div>
                            </SwiperSlide>
                        ))}
                    </GeneralSwiper>
                    {newsData.length > 1 && (
                        <GeneralSwiperPagination customClass="swiper-news-pagination" />
                    )}
                </div>
            </GeneralContainer>
        </section>
    );
};

export default NewsSection;
