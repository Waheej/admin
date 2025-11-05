import ProjectsPage from '@/app/components/pages/ProjectsPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

export async function generateMetadata({ params }: { params: { locale: string } }): Promise<Metadata> {
  const lang = params.locale || "en";
  return await generalMetaTag("/projects", lang);
}

export default function page() {
  return <ProjectsPage />
}