import GeneralBanner from "@/app/components/common/generalBanner/GeneralBanner";
import SingleMediaCenterDetails from "@/app/components/ui/singleMediaCenterDetails/SingleMediaCenterDetails";
import React from "react";

const SingleMediaCenterPage = () => {
    return (
        <>
            <GeneralBanner
                title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate quisquam veniam assumenda? Esse, facere!"
                imageSrc="/images/image.png"
            />
            <SingleMediaCenterDetails />
            
        </>
    );
};

export default SingleMediaCenterPage;
