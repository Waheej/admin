"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import Logo from "@/app/components/common/logo/Logo";
import PillEffect from "@/app/components/module/pillModule/PillModule";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { Link } from "@/i18n/navigation";
import React, { useRef, useMemo } from "react";
import { FaFacebookF } from "react-icons/fa";
import { BiLogoTiktok } from "react-icons/bi";
import { FiSend } from "react-icons/fi";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import clsx from "clsx";
import { useLocale } from "next-intl";
import { useTranslations } from "next-intl";
import { useQuery } from "@tanstack/react-query";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import { FaInstagram, FaSnapchatGhost, FaTwitter } from "react-icons/fa";
import { FaXTwitter } from "react-icons/fa6";
import { HiMail, HiPhone, HiLocationMarker } from "react-icons/hi";
import { MdOutlinePhonelinkRing } from "react-icons/md";
import { IoLocationOutline, IoMailOutline } from "react-icons/io5";

gsap.registerPlugin(ScrollTrigger);

const Footer = () => {
    const [isFooterwhite, setIsFooterwhite] = React.useState(false);
    const footerRef = useRef<HTMLDivElement>(null);
    const lang = useLocale();
    const t = useTranslations();

    // ✅ جلب المشاريع من API
    const { data: projectsData } = useQuery({
        queryKey: ["projectsList", lang],
        queryFn: () => handleFetchRequest("projectsList", "GET", null, lang),
        staleTime: 1000 * 60 * 5,
    });

    // ✅ جلب معلومات التواصل من API
    const { data: infoData } = useQuery({
        queryKey: ["getInfo", lang],
        queryFn: () => handleFetchRequest("getInfo", "GET", null, lang),
        staleTime: 1000 * 60 * 5,
    });

    // ✅ Icons mapping حسب الـ key
    const getIconByKey = (key: string) => {
        const iconMap: Record<string, any> = {
            facebook: <FaFacebookF size={18} />,
            instagram: <FaInstagram size={18} />,
            tiktok: <BiLogoTiktok size={18} />,
            snapchat: <FaSnapchatGhost size={18} />,
            x: <FaXTwitter size={18} />,
            twitter: <FaTwitter size={18} />,
            email: <IoMailOutline size={18} />,
            phone: <MdOutlinePhonelinkRing size={18} />,
            address: <IoLocationOutline size={18} />,
        };
        return iconMap[key] || <FiSend size={18} />;
    };

    // ✅ فلترة السوشيال ميديا فقط
    const socialMedia = useMemo(() => {
        if (!infoData?.data) return [];
        return infoData.data.filter((item: any) => ["facebook", "instagram", "tiktok", "snapchat", "x", "twitter"].includes(item.key));
    }, [infoData]);

    // ✅ فلترة معلومات التواصل
    const contactInfo = useMemo(() => {
        if (!infoData?.data) return [];
        return infoData.data.filter((item: any) => ["email", "phone", "address"].includes(item.key));
    }, [infoData]);

    // ✅ Quick Navigation
    const quickNavigation = useMemo(
        () => ({
            title: t("menu.quick_navigation"),
            links: [
                { id: 1, label: t("menu.home"), link: "/" },
                { id: 2, label: t("menu.about_us"), link: "/about-us" },
                { id: 3, label: t("menu.projects"), link: "/projects" },
                { id: 4, label: t("menu.media_center"), link: "/media-center" },
            ],
        }),
        [t],
    );

    // ✅ تجميع المشاريع حسب النوع
    const projectsByCategory = useMemo(() => {
        // 1) طبعًا هنعمل normalize للداتا قبل ما نلمسها
        const raw = projectsData?.data;

        const list: any[] =
            Array.isArray(raw)
                ? raw
                : typeof raw === "string"
                    ? (() => {
                        try {
                            const parsed = JSON.parse(raw);
                            return Array.isArray(parsed) ? parsed : [];
                        } catch {
                            return [];
                        }
                    })()
                    : Array.isArray((raw as any)?.items)
                        ? (raw as any).items
                        : [];

        if (list.length === 0) return [];

        // 2) نجمع حسب النوع بأمان
        const grouped: Record<string, { categoryName: string; projects: any[] }> = {};

        for (const item of list) {
            const project = item ?? {}; // أمان
            const typeKey =
                project.apartment_type_key ??
                project.apartment_type ??
                "other";

            const typeValue =
                project.apartment_type_value ??
                project.apartment_type ??
                project.apartment_type_key ??
                "Other";

            if (!grouped[typeKey]) {
                grouped[typeKey] = { categoryName: String(typeValue), projects: [] };
            }
            grouped[typeKey].projects.push(project);
        }

        // 3) رجّع Array بالشكل المطلوب
        return Object.values(grouped).map(({ categoryName, projects }) => ({
            categoryName,
            projects: projects.slice(0, 4).map((p: any) => ({
                id: p.id,
                name: p.name,
                link: `/projects/${p.id}`,
            })),
        }));
        // خليك محدد في الـ deps عشان ما تعيد الحساب من غير داعي
    }, [projectsData?.data]);


    useGSAP(
        () => {
            if (!footerRef.current) return;

            const footer = footerRef.current;

            ScrollTrigger.create({
                trigger: footer,
                start: "top center",
                // onEnter: () => setIsFooterwhite(true),
                // onLeaveBack: () => setIsFooterwhite(false),
            });

            // gsap.fromTo(
            //     footer,
            //     { backgroundColor: "#fff" },
            //     {
            //         backgroundColor: "#000",
            //         duration: 0.5,
            //         ease: "power3.out",
            //         scrollTrigger: {
            //             trigger: footer,
            //             start: "top center",
            //             end: "top top",
            //             scrub: true,
            //         },
            //     }
            // );

            const revealElements = footer.querySelectorAll(".reveal-ele");
            if (revealElements.length > 0) {
                gsap.fromTo(
                    revealElements,
                    { y: 100, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "power3.out",
                        stagger: 0.05,
                        scrollTrigger: {
                            trigger: footer,
                            start: "top 80%",
                        },
                    },
                );
            }

            ScrollTrigger.refresh();

            return () => {
                ScrollTrigger.getAll().forEach((t) => t.kill());
                gsap.killTweensOf(revealElements);
                gsap.killTweensOf(footer);
            };
        },
        { scope: footerRef },
    );

    return (
        <footer
            ref={footerRef}
            className={clsx("footer  overflow-hidden p-4", {
                // "text-white": isFooterwhite,
            })}>
            <GeneralContainer isSection customClass="bg-black rounded-3xl">
                {/* ======== GRID SECTION ======== */}
                <div className="footer-top grid xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-10">
                    <div className="footer-logo col-span-1 ">
                        <Logo />
                        <div className="overflow-hidden">
                            <p className="my-4 reveal-ele text-white">{t("common.company_description")}</p>
                        </div>
                    </div>

                    <div className="footer-navigation col-span-1 ">
                        <div className="overflow-hidden">
                            <h2 className="text-white text-lg mb-4 reveal-ele uppercase">{quickNavigation.title}</h2>
                        </div>
                        <ul className="flex flex-col gap-4 ">
                            {quickNavigation.links.map((link) => (
                                <div className="overflow-hidden" key={link.id}>
                                    <li className="reveal-ele">
                                        <PillEffect>
                                            <Link href={link.link} className=" text-white/80 hover:text-white duration-300 inline-block uppercase">
                                                {link.label}
                                            </Link>
                                        </PillEffect>
                                    </li>
                                </div>
                            ))}
                        </ul>
                    </div>

                    <div className="footer-projects col-span-1">
                        <div className="overflow-hidden">
                            <h2 className="text-white text-xl mb-4 reveal-ele uppercase">{t("menu.projects")}</h2>
                        </div>
                        <div className="space-y-6 grid xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-4 ">
                            {projectsByCategory.map((category, idx) => (
                                <div key={idx}>
                                    <div className="overflow-hidden">
                                        <h3 className="text-white text-sm mb-3 reveal-ele uppercase font-medium">{category.categoryName}</h3>
                                    </div>
                                    <ol className="flex flex-col gap-2">
                                        {category.projects.map((project: any) => (
                                            <div className="overflow-hidden" key={project.id}>
                                                <li className="reveal-ele  flex items-center gap-2">
                                                    <PillEffect>
                                                        <Link href={project.link} className="uppercase text-white/70 hover:text-white duration-300  text-sm  flex items-center gap-2">
                                                            {project.name}
                                                        </Link>
                                                    </PillEffect>
                                                </li>
                                            </div>
                                        ))}
                                    </ol>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="footer-location col-span-full flex justify-between items-center flex-wrap gap-4 space-y-6 ">
                        {/* Contact Info */}
                        {contactInfo.length > 0 && (
                            <div>
                                <h2 className="uppercase text-lg mb-4 reveal-ele text-white">{t("footer.contact_info") || "Contact Info"}</h2>
                                <div className="space-y-3">
                                    {contactInfo.map((info: any) => (
                                        <div key={info.id} className="flex items-center gap-3 text-white/70 hover:text-white transition-colors reveal-ele cursor-pointer">
                                            <div className="">{getIconByKey(info.key)}</div>
                                            <span className="text-sm">{info.value}</span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Social Media */}
                        <div>
                            <h2 className="uppercase text-lg mb-4 reveal-ele text-white ">{t("footer.social_desc")}</h2>
                            <div className="footer-location-contact flex gap-2 flex-wrap reveal-ele">
                                {socialMedia.length > 0 ? (
                                    socialMedia.map((social: any) => (
                                        <GeneralButton
                                            key={social.id}
                                            icon={getIconByKey(social.key)}
                                            isWhite
                                            isPillEffect
                                            customClass="duration-300 transition-colors"
                                            customClick={() => window.open(social.value, "_blank")}
                                        />
                                    ))
                                ) : (
                                    // Fallback لو مفيش data
                                    <>
                                        <GeneralButton icon={<FaFacebookF size={18} />} isWhite isPillEffect customClass="duration-300 transition-colors" />
                                        <GeneralButton icon={<BiLogoTiktok size={18} />} isWhite isPillEffect customClass="duration-300 transition-colors" />
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                <div className="footer-bottom  pt-6">
                    <div className="overflow-hidden">
                        <p
                            className={clsx("reveal-ele text-white/60 text-sm capitalize", {
                                // "text-white/60": isFooterwhite,
                            })}>
                            {`${t("footer.copyright")} ${String.fromCharCode(169)} ${new Date().getFullYear()} ${t("common.waheej")}`}
                        </p>
                    </div>
                </div>
            </GeneralContainer>
        </footer>
    );
};

export default Footer;
