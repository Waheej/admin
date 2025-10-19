import clsx from "clsx";
import React from "react";

type TGeneralContainer = {
    customClass?: string;
    children: React.ReactNode;
    isSection?: boolean;
};
const GeneralContainer: React.FC<TGeneralContainer> = ({ children, customClass, isSection }) => {
    return (
        <div
            className={clsx(
                "general-container xl:px-[2rem] lg:px-[2rem] md:px-[1.5rem] px-[1rem] h-full w-full relative",
                {
                    "xl:py-[3.5rem] lg:py-[4.5rem] md:py-[3.5rem] py-[2.5rem]": isSection,
                },
                customClass,
            )}>
            {children}
        </div>
    );
};

export default GeneralContainer;
