import SingleProjectPage from '@/app/components/ui/singleProjectPage/SingleProjectPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata(props: { params: Promise<{ locale: string; slug: string }> }): Promise<Metadata> {
  const params = await props.params; 
  return await generalMetaTag(`/projectDetails/${params.slug}`, params.locale);
}

export default async function page(props: { params: Promise<{ locale: string; slug: string }> }) {
  const params = await props.params;
  return <SingleProjectPage slug={params.slug} />
}