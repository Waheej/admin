import { MetadataRoute } from 'next';

export default function sitemap(): MetadataRoute.Sitemap {
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://waheejsa.com';
  const locales = ['ar', 'en'];

  const routes = [
    '',
    '/about-us',
    '/projects',
    '/media-center',
  ];

  const sitemap: MetadataRoute.Sitemap = [];

  // Add routes for each locale
  routes.forEach((route) => {
    locales.forEach((locale) => {
      sitemap.push({
        url: `${baseUrl}/${locale}${route}`,
        lastModified: new Date(),
        changeFrequency: route === '' ? 'daily' : 'weekly',
        priority: route === '' ? 1 : 0.8,
        alternates: {
          languages: {
            ar: `${baseUrl}/ar${route}`,
            en: `${baseUrl}/en${route}`,
          },
        },
      });
    });
  });

  return sitemap;
}

