import MediaCenterPage from '@/app/components/pages/MediaCenterPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata({ params }: { params: Promise<{ locale: string }> }): Promise<Metadata> {
    const { locale } = await params;
    return await generalMetaTag("/media-center", locale);
}

export default function page() {
  return <MediaCenterPage />
}