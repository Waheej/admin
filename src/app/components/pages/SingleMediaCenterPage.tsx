"use client";
import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import SingleMediaCenterDetails from "@/app/components/ui/singleMediaCenterDetails/SingleMediaCenterDetails";
import { useQuery } from "@tanstack/react-query";
import { useLocale } from "next-intl";
import React from "react";

const SingleMediaCenterPage = ({ slug }: { slug: string }) => {
    const userLang = useLocale();
    const { data, isLoading, isError } = useQuery({
        queryKey: ["news", slug],
        queryFn: () => handleFetchRequest(`/newsDetails/${slug}`, "GET", null, userLang),
        retry: 2,
    }); 

    return (
        <>
            <GeneralBanner
                title={data?.data?.title || ""}
                imageSrc={data?.data?.media_path || "/images/media_center.png"}
            />
            <SingleMediaCenterDetails data={data?.data} />
            
        </>
    );
};

export default SingleMediaCenterPage;
