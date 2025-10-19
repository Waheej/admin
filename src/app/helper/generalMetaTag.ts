import type { Metadata } from "next";

export async function generalMetaTag(path: string, lang: string = "en"): Promise<Metadata> {
    const siteUrl = process.env.NEXT_PUBLIC_SITE_URL || "https://waheejsa.com";
    
    // Default fallback metadata
    const defaultMetadata: Metadata = {
        title: "وهيج | Waheej - العقارات في السعودية",
        description: "استثمر واسكن في السعودية: فرص عقارية مميزة",
        keywords: "عقارات السعودية، استثمار عقاري، شقق للبيع، فلل للبيع",
        openGraph: {
            title: "Waheej",
            description: "استثمر واسكن في السعودية: فرص عقارية مميزة",
            url: siteUrl,
            siteName: "Waheej",
            images: [{ 
                url: `${siteUrl}/images/logo/logo-rect-light.svg`, 
                width: 1200, 
                height: 630, 
                alt: "Waheej" 
            }],
            type: "website",
            locale: lang === 'ar' ? 'ar_SA' : 'en_US',
        },
        twitter: {
            card: "summary_large_image",
            title: "Waheej",
            description: "استثمر واسكن في السعودية: فرص عقارية مميزة",
        },
        alternates: { 
            canonical: `${siteUrl}${path}`,
            languages: {
                'ar': `/ar${path}`,
                'en': `/en${path}`,
            },
        },
    };

    try {
        const baseUrl = process.env.NEXT_PUBLIC_API_URL_STAGING || "https://admin.waheejsa.com/api/";
        const apiPath = path.startsWith("/") ? path.slice(1) : path;
        const fullUrl = `${baseUrl}${apiPath}`;


        // Fetch with timeout to prevent hanging
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 3000); // 3s timeout

        const response = await fetch(fullUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'lang': lang,
            },
            signal: controller.signal,
            next: { revalidate: 3600 }, // Cache for 1 hour
        });

        clearTimeout(timeoutId);

        if (!response.ok) {
            return defaultMetadata;
        }

        const data = await response.json();
        const seo = data?.data?.seo || {};
        const pageTitle = data?.data?.page_title || "Waheej";

        if (!seo || Object.keys(seo).length === 0) {
            return defaultMetadata;
        }

        const { title, description, canonical_url, url, robots, keywords, og, twitter } = seo;

        const siteUrl = process.env.NEXT_PUBLIC_SITE_URL || "https://waheejsa.com";
        const ogImage = og?.image || `${siteUrl}/images/logo/logo-rect-light.svg`;
        const twitterImage = twitter?.image || `${siteUrl}/images/logo/logo-rect-light.svg`;

        return {
            title: title || `Waheej | ${pageTitle}`,
            description: description?.replace(/<[^>]*>/g, "") || "استثمر واسكن في السعودية: فرص عقارية مميزة",
            keywords: keywords || "عقارات السعودية، استثمار عقاري",
            openGraph: {
                title: og?.title || title || `Waheej | ${pageTitle}`,
                description: og?.description?.replace(/<[^>]*>/g, "") || description?.replace(/<[^>]*>/g, ""),
                url: og?.url || url || siteUrl,
                siteName: "Waheej",
                images: [{ url: ogImage, width: 1200, height: 630, alt: og?.title || title || "Waheej" }],
                type: "website",
                locale: lang === 'ar' ? 'ar_SA' : 'en_US',
            },
            twitter: {
                card: "summary_large_image",
                title: twitter?.title || title || `Waheej | ${pageTitle}`,
                description: twitter?.description?.replace(/<[^>]*>/g, "") || description?.replace(/<[^>]*>/g, ""),
                images: [twitterImage],
            },
            alternates: { 
                canonical: canonical_url || url || `${siteUrl}${path}`,
                languages: {
                    'ar': `/ar${path}`,
                    'en': `/en${path}`,
                },
            },
        };
    } catch (error) {
        return defaultMetadata;
    }
}
