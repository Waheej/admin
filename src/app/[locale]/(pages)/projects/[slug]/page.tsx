import SingleProjectPage from '@/app/components/ui/singleProjectPage/SingleProjectPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata({ params }: { params: { locale: string; slug: string } }): Promise<Metadata> {
  const lang = params.locale || "en";
  const slug = params.slug || "";
  return await generalMetaTag(`/projectDetails/${slug}`, lang);
}
export default function page({ params }: { params: { locale: string; slug: string } }) {
  const slug = params.slug || "";
  return <SingleProjectPage slug={slug} />
}