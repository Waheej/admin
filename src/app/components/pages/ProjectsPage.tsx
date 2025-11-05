"use client"
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import ProjectsPageSection from "@/app/components/ui/projectsPageSection/ProjectsPageSection";
import { useQuery } from "@tanstack/react-query";
import { useLocale, useTranslations } from "next-intl";
import React from "react";

const ProjectsPage = () => {
    const userLang = useLocale();
    const t = useTranslations();
    const { data, isLoading, isError, error } = useQuery({
        queryKey: ["projectsList", userLang],
        queryFn: async () => {
            const res = await handleFetchRequest("projectsList", "GET", null, userLang);
            return res || {};
        },
        staleTime: 1000 * 60 * 5,
        retry: 2,
    });

    return (
        <>
            <GeneralBanner
                title={t("pages.projects_title")}
                imageSrc="/images/banner.png"
            />
            <ProjectsPageSection data={data?.data?.sections} />
        </>
    );
};

export default ProjectsPage;
