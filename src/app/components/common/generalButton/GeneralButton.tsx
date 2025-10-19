"use client";
import MagnetModule from "@/app/components/module/magnetModule/MagnetModule";
import PillEffect from "@/app/components/module/pillModule/PillModule";
import { Link } from "@/i18n/navigation";
import clsx from "clsx";
import { useRouter } from "next/navigation";
import React from "react";

type TGeneralButton = {
    title?: string;
    customClass?: string;
    icon?: React.ReactNode;
    isWhite?: boolean;
    isBlack?: boolean;
    isGray?: boolean;
    isPillEffect?: boolean;
    isFlip?: boolean;
    isProjectBtn?: boolean;
    customClick?: () => void;
    isDownloadBorochure?: boolean;
    url?: string;
    type?: "button" | "submit" | "reset";
    disabled?: boolean;
};

const GeneralButtonComponent: React.FC<TGeneralButton> = ({
    title,
    customClass,
    icon,
    isWhite,
    isBlack,
    isGray,
    isPillEffect,
    isFlip,
    isProjectBtn,
    customClick,
    isDownloadBorochure,
    url,
    type,
    disabled,
}) => {
    const route = useRouter();

    const classes = clsx(
        "general-button-container rounded-full px-6 min-h-[3rem] min-w-[3rem] place-content-center font-[500] cursor-pointer w-fit cursor-target font-gruppos text-base uppercase flex items-center justify-center gap-2",
        {
            "bg-white !text-dark": isWhite,
            "bg-dark !text-white": isBlack,
            "bg-gray/60 !text-dark": isGray,
            "!py-0 !px-0 min-h-14 min-w-14 flex items-center justify-center ": !title,
            "opacity-60 cursor-not-allowed": disabled,
        },
        customClass,
    );

    const content = (
        <>
            {isPillEffect ? (
                <PillEffect>
                    <span
                        className={clsx("flex items-center justify-between gap-2", {
                            "flex-row-reverse": isFlip,
                        })}>
                        {icon && icon}
                        {title && title}
                    </span>
                </PillEffect>
            ) : (
                <span
                    className={clsx("flex items-center gap-2 justify-between", {
                        "flex-row-reverse": isFlip,
                    })}>
                    {icon && icon}
                    {title && title}
                </span>
            )}
        </>
    );

    if (url) {
        return (
            <Link href={url} onClick={customClick} className={classes}>
                {content}
            </Link>
        );
    }
    if (type) {
        return (
            <button type={type || "button"} onClick={customClick} className={classes} disabled={disabled}>
                {content}
            </button>
        );
    }

    return (
        <div onClick={customClick} className={classes}>
            {content}
        </div>
    );
};

const GeneralButton = React.memo(GeneralButtonComponent);

export default GeneralButton;
