import MediaCenterPage from '@/app/components/pages/MediaCenterPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata({ params }: { params: { locale: string } }): Promise<Metadata> {
  const lang = params.locale || "en";
  return await generalMetaTag("/newsList", lang);
}

export default function page() {
  return <MediaCenterPage />
}