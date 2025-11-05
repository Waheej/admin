import SingleMediaCenterPage from "@/app/components/pages/SingleMediaCenterPage";
import { generalMetaTag } from "@/app/helper/generalMetaTag";
import type { Metadata } from "next";

export async function generateMetadata({ params }: { params: { locale: string; slug: string } }): Promise<Metadata> {
  const lang = params.locale || "en";
  const slug = params.slug || "";
  return await generalMetaTag(`/newsDetails/${slug}`, lang);
}

export default function page({ params }: { params: { locale: string; slug: string } }) {
  const slug = params.slug || "";
  return <SingleMediaCenterPage slug={slug} />;
}
