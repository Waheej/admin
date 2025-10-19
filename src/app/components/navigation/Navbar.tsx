"use client";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralForm from "@/app/components/common/generalForm/GeneralForm";
import Logo from "@/app/components/common/logo/Logo";
import SwitchLang from "@/app/components/common/switchLang/SwitchLang";
import ToggleMenuIcon from "@/app/components/common/toggleMenuIcon/ToggleMenuIcon";
import GeneralContainer from "@/app/components/wrappers/generalContainer/GeneralContainer";
import { sendIcon } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import useToggleMenu from "@/app/store/useToggleMenu";
import useNotFoundPage from "@/app/store/useNotFoundPage";
import { useLenis } from "lenis/react";
import { useTranslations } from "next-intl";
import React from "react";
import { FiSend } from "react-icons/fi";
import { HiOutlineMail } from "react-icons/hi";

const Navbar = () => {
    const menuItems = [
        { label: "Home", ariaLabel: "Go to home page", link: "/" },
        { label: "About", ariaLabel: "Learn about us", link: "/about" },
        { label: "Services", ariaLabel: "View our services", link: "/services" },
        { label: "Contact", ariaLabel: "Get in touch", link: "/contact" },
    ];

    const socialItems = [
        { label: "Twitter", link: "https://twitter.com" },
        { label: "GitHub", link: "https://github.com" },
        { label: "LinkedIn", link: "https://linkedin.com" },
    ];
    const lenis = useLenis();
    const { setChildren } = useGeneralPopUp((state) => state);
    const t = useTranslations();
    const { closeMenu } = useToggleMenu();
    const { isNotFoundPage } = useNotFoundPage();
    return (
        <header className="header absolute top-10 left-1/2 -translate-x-1/2 w-[95%]  z-30 ">
            <GeneralContainer customClass="flex items-center justify-between">
                <Logo isDark={isNotFoundPage} />
                <div className="flex items-center gap-2">
                    <GeneralButton
                        title={t("common.enquiry_now")}
                        isWhite
                        customClass="xl:block lg:block md:block hidden"
                        isFlip
                        isPillEffect
                        icon={sendIcon}
                        customClick={() => {
                            const section = document.querySelector("#contact");
                            if (section) {
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
                                closeMenu()
                            }
                        }}
                    />
                    <SwitchLang />
                    <ToggleMenuIcon />
                </div>
            </GeneralContainer>
        </header>
    );
};

export default Navbar;
