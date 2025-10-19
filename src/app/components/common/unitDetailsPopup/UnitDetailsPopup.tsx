import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralForm from "@/app/components/common/generalForm/GeneralForm";
import ParallaxImage from "@/app/components/module/parallaxImage/ParallaxImage";
import { callIcon, locationIcon, sendIcon } from "@/app/data/data";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import useToggleMenu from "@/app/store/useToggleMenu";
import { useLenis } from "lenis/react";
import { useLocale, useTranslations } from "next-intl";
import Image from "next/image";
import React from "react";

const UnitDetailsPopup = ({ project }: { project: any }) => {
    const { closeMenu } = useToggleMenu();
    const lenis = useLenis();
    const setChildren = useGeneralPopUp((state) => state.setChildren);
    const t = useTranslations();
    const lang = useLocale();
    return (
        <div className="unit-details-popup h-full w-full p-6 flex flex-col justify-between">
            <div className="unit-details-popup-content pt-6 ">
                <div className="unit-details-popup-content-top mb-8 flex flex-wrap items-center gap-4 justify-between">
                    <div className="unit-details-popup-content-bottom-location flex items-center gap-2">
                        <div className="unit-details-popup-content-bottom-location-icon flex items-center justify-center bg-gray w-12 h-12 rounded-full">{locationIcon}</div>
                        <span>{project?.city}</span>
                    </div>
                    <div className="unit-details-popup-content-bottom-btns flex items-center gap-2">
                        <GeneralButton
                            title={t("unit_details.fill_form")}
                            icon={sendIcon}
                            isBlack
                            customClick={() => {
                                const section = document.querySelector("#contact");
                                if (section) {
                                    lenis?.scrollTo(section as HTMLElement, {
                                        offset: 0,
                                        duration: 1.2,
                                        easing: (t) => 1 - Math.pow(1 - t, 3),
                                    });
                                } else {
                                    setChildren(<GeneralForm project_id={project?.parent_id} customClass="!bg-white mx-auto xl:w-1/2 lg:w-1/2 md:w-1/2 w-full p-8 rounded-2xl" />, "contact");
                                    closeMenu();
                                }
                            }}
                        />
                        <GeneralButton icon={callIcon} isBlack />
                    </div>
                </div>
                <h2 className="text-3xl uppercase">{project?.name}</h2>
                <p className="xl:w-3/4 lg:w-3/4 md:w-3/4 w-full line-clamp-6" dangerouslySetInnerHTML={{ __html: project?.description }}>
                </p>
                
                <div className="unit-details-popup-content-bottom-specs my-8 flex items-center gap-4 overflow-x-auto">
                    <div className="flex flex-col border border-gray rounded-2xl p-4 min-w-[150px]">
                        <span className="text-gray-500 text-sm uppercase">{t("unit_details.price")}</span>
                        <span className="text-lg text-primary">{project?.price} {lang === "ar" ? "ريال" : "SAR"}</span>
                    </div>
                </div>
                
            </div>
            <div className="unit-details-popup-image relative h-[50%] w-full rounded-3xl overflow-hidden">
                <Image src="/images/banner.png" alt="Unit details" fill className="object-cover" sizes="(max-width: 768px) 100vw, 50vw" />
            </div>
        </div>
    );
};

export default UnitDetailsPopup;
