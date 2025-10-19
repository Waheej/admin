import ProjectsPage from '@/app/components/pages/ProjectsPage'
import { generalMetaTag } from '@/app/helper/generalMetaTag';
import type { Metadata } from 'next';

// export async function generateMetadata({ params }: { params: Promise<{ locale: string }> }): Promise<Metadata> {
//     const { locale } = await params;
//     return await generalMetaTag("/projects", locale);
// }

export default function page() {
  return <ProjectsPage />
}