import SingleMediaCenterPage from "@/app/components/pages/SingleMediaCenterPage";
import { generalMetaTag } from "@/app/helper/generalMetaTag";
import type { Metadata } from "next";

export async function generateMetadata(props: { params: Promise<{ locale: string; slug: string }> }): Promise<Metadata> {
  const params = await props.params; 
  return await generalMetaTag(`/media-center/${params.slug}`, params.locale);
}

export default function page() {
    return <SingleMediaCenterPage />;
}
