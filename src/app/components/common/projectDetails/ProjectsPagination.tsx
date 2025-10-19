import clsx from "clsx";
import React from "react";

const ProjectsPagination = () => {
    return (
        <div className={clsx("projects-pagination py-4 text-white absolute bottom-0 w-[100vw] flex items-center justify-start flex-nowrap gap-4 overflow-auto")}>
            {Array.from({ length: 5 }, (_, index) => (
                <div className="projects-pagination-container grow shrink-0 max-w-1/4" key={index}>
                    <p className="flex items-center gap-2 text-xl capitalize mb-4">
                        <span>0{index+1}.</span>
                        <span>General info</span>
                    </p>
                    <div className="projects-pagination-container-line h-[1px] bg-white/20">
                        <div className="projects-pagination-container-line-tab h-full w-1/2 bg-white"></div>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default ProjectsPagination;
