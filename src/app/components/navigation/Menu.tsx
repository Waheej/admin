"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralForm from "@/app/components/common/generalForm/GeneralForm";
import SwitchLang from "@/app/components/common/switchLang/SwitchLang";
import PillEffect from "@/app/components/module/pillModule/PillModule";
import { markerIcon, menuItems, socialItems } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import { useLenisStore } from "@/app/store/useLenisStore";
import useToggleMenu from "@/app/store/useToggleMenu";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { useLocale, useTranslations } from "next-intl";
import { Link } from "@/i18n/navigation";
import React, { useRef, useEffect, useMemo } from "react";
import { FaFacebookF, FaInstagram, FaSnapchatGhost } from "react-icons/fa";
import { BiLogoTiktok } from "react-icons/bi";
import { FaXTwitter } from "react-icons/fa6";
import { FiSend } from "react-icons/fi";
import { IoClose } from "react-icons/io5";
import { useQuery } from "@tanstack/react-query";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";

const Menu = () => {
    const containerRef = useRef<HTMLDivElement>(null);
    const darkLayerRef = useRef<HTMLDivElement>(null);
    const whiteLayerRef = useRef<HTMLDivElement>(null);

    const { isOpen } = useToggleMenu();
    const tl = useRef<gsap.core.Timeline | null>(null);
    const { lenis } = useLenisStore();
    const { setChildren } = useGeneralPopUp((state) => state);
    const t = useTranslations();
    const { closeMenu } = useToggleMenu();
    const lang = useLocale();

    // ✅ جلب معلومات التواصل من API
    const { data: infoData } = useQuery({
        queryKey: ["getInfo", lang],
        queryFn: () => handleFetchRequest("getInfo", "GET", null, lang),
        staleTime: 1000 * 60 * 5,
    });

    // ✅ Icons mapping حسب الـ key
    const getIconByKey = (key: string) => {
        const iconMap: Record<string, any> = {
            facebook: <FaFacebookF size={20} />,
            instagram: <FaInstagram size={20} />,
            tiktok: <BiLogoTiktok size={20} />,
            snapchat: <FaSnapchatGhost size={20} />,
            x: <FaXTwitter size={20} />,
        };
        return iconMap[key] || <FiSend size={20} />;
    };

    // ✅ فلترة السوشيال ميديا فقط
    const socialMedia = useMemo(() => {
        if (!infoData?.data) return [];
        return infoData.data.filter((item: any) => 
            ['facebook', 'instagram', 'tiktok', 'snapchat', 'x', 'twitter'].includes(item.key)
        );
    }, [infoData]);

    // ✅ جلب العنوان من API
    const addressInfo = useMemo(() => {
        if (!infoData?.data) return null;
        return infoData.data.find((item: any) => item.key === 'address');
    }, [infoData]);
    useGSAP(
        () => {
            if (!containerRef.current || !darkLayerRef.current || !whiteLayerRef.current) return;

            tl.current = gsap.timeline({
                paused: true,
                defaults: { ease: "power3.inOut", duration: 0.6 },
            });

            // إعداد البداية
            gsap.set([darkLayerRef.current, whiteLayerRef.current], {
                clipPath: "ellipse(100% 0% at 50% 100%)",
                visibility: "visible",
            });
            gsap.set(containerRef.current, { visibility: "hidden" });

            // الخط الزمني
            tl.current
                .set(containerRef.current, { visibility: "visible" })
                // أول حاجة: الداكن يفتح
                .to(whiteLayerRef.current, {
                    clipPath: "ellipse(100% 120% at 50% 98%)",
                    duration: 1,
                })
                // بعده الأبيض
                .to(
                    darkLayerRef.current,
                    {
                        clipPath: "ellipse(100% 120% at 50% 98%)",
                        duration: 1,
                    },
                    "-=0.3",
                ) // overlap مع الداكن
                // بعدين العناصر - مع تحقق من وجودها
                .add(() => {
                    const menuItems = containerRef.current?.querySelectorAll(".menu-item");
                    if (menuItems && menuItems.length > 0) {
                        gsap.fromTo(menuItems, 
                            { y: 100, opacity: 0 }, 
                            { y: 0, opacity: 1, stagger: 0.05, duration: 0.5, ease: "power3.out" }
                        );
                    }
                }, "-=0.2");
        },
        { scope: containerRef, dependencies: [addressInfo, socialMedia] },
    );

    useEffect(() => {
        if (!tl.current) return;
        
        if (isOpen) {
            // إعادة إنشاء الأنيميشن إذا تغيرت البيانات
            if (tl.current.isActive()) {
                tl.current.kill();
            }
            
            // إعادة تشغيل الأنيميشن مع البيانات الجديدة
            setTimeout(() => {
                if (tl.current) {
                    tl.current.play();
                }
            }, 50);
            
            lenis?.stop();
        } else {
            tl.current.reverse().eventCallback("onReverseComplete", () => {
                if (containerRef.current) {
                    gsap.set(containerRef.current, { visibility: "hidden" });
                }
                lenis?.start();
            });
        }
    }, [isOpen, lenis, addressInfo, socialMedia]);
    const menuItems = [
        { label: t("menu.home"), ariaLabel: "Go to home page", link: "/" },
        { label: t("menu.about_us"), ariaLabel: "Learn about us", link: "/about-us" },
        { label: t("menu.projects"), ariaLabel: "View our services", link: "/projects" },
        { label: t("menu.media_center"), ariaLabel: "Get in touch", link: "/media-center" },
        // { label: "Contact", ariaLabel: "Get in touch", link: "/contact" },
    ];
    return (
        <aside ref={containerRef} className="fixed right-0 top-0 h-screen w-full z-20 flex flex-col justify-between invisible">
            <div ref={whiteLayerRef} className="absolute inset-0 bg-white"></div>
            <div ref={darkLayerRef} className="absolute inset-0 bg-black"></div>

            <div className="relative h-full z-10 pt-30 pb-4  w-[90%] mx-auto flex flex-row items-center flex-wrap md:flex-nowrap justify-between">
                <ul className="flex flex-col gap-2 w-fit">
                    {menuItems.map((item, index) => (
                        <PillEffect key={index}>
                            <li className="flex items-start gap-2 overflow-hidden text-white ">
                                <Link href={item.link} className="xl:text-5xl lg:text-4xl text-3xl uppercase pt-4 menu-item">
                                    {item.label}
                                </Link>
                            </li>
                        </PillEffect>
                    ))}
                </ul>
                <div className="flex  justify-between items-start gap-4 flex-wrap">
                    <ul className="xl:hidden lg:hidden md:hidden flex items-center gap-4 uppercase w-1/2">
                        <li className="menu-item">
                            <SwitchLang customClass="xl:!hidden lg:!hidden md:!hidden !block" />
                        </li>
                        <li className="menu-item">
                            <GeneralButton
                                title={t("common.enquiry_now")}
                                isWhite
                                isFlip
                                isPillEffect
                                icon={<FiSend size={20} />}
                                customClick={() => {
                                    const section = document.querySelector("#contact");
                                    if (section) {
                                        closeMenu();
                                        setTimeout(() => {
                                            lenis?.start()
                                            lenis?.scrollTo(section as HTMLElement, {
                                                offset: 0,
                                                duration: 2,
                                                easing: (t) => 1 - Math.pow(1 - t, 3),
                                            });
                                        }, 2000);
                                    } else {
                                        setChildren(<GeneralForm customClass="!bg-white mx-auto xl:w-1/2 lg:w-1/2 md:w-1/2 w-full p-8 rounded-2xl" />, "contact");
                                        closeMenu();
                                    }
                                }}
                            />
                        </li>
                    </ul>
                    <ul className="xl:flex lg:flex md:flex hidden flex-col uppercase gap-10 text-white">
                        {addressInfo && (
                            <div>
                                <li className="overflow-hidden">
                                    <span className="inline-block menu-item text-white mb-2">{t("common.location")}</span>
                                </li>
                                <li className="overflow-hidden">
                                    <span className="flex items-center gap-2 text-white/80 menu-item">
                                        {markerIcon} {addressInfo.value}
                                    </span>
                                </li>
                            </div>
                        )}
                        
                        <div>
                            <li className="overflow-hidden">
                                <span className="inline-block menu-item text-white mb-2">{t("common.social")}</span>
                            </li>
                            <div className="flex items-center gap-4 flex-wrap">
                                {socialMedia.length > 0 ? (
                                    socialMedia.map((social: any) => (
                                        <div key={social.id} className="overflow-hidden">
                                            <div className="menu-item">
                                                <GeneralButton 
                                                    isWhite 
                                                    icon={getIconByKey(social.key)}
                                                    customClick={() => window.open(social.value, '_blank')}
                                                />
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    socialItems.map((item, index) => (
                                        <div key={index} className="overflow-hidden">
                                            <Link href={item.link} className="menu-item">
                                                <GeneralButton isWhite icon={<FaFacebookF size={20} />} />
                                            </Link>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </aside>
    );
};

export default Menu;
