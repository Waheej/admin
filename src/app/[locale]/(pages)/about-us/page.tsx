import AboutUsPage from '@/app/components/pages/AboutUsPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata({ params }: { params: Promise<{ locale: string }> }): Promise<Metadata> {
    const { locale } = await params;
    return await generalMetaTag("/about-us", locale);
}

export default function page() {
  return <AboutUsPage />
}