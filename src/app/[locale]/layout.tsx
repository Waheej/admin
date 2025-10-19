import type { Metadata } from "next";
import { Tajawal, Cinzel } from "next/font/google";
import "../globals.css";
import { hasLocale, NextIntlClientProvider } from "next-intl";
import { notFound } from "next/navigation";
import { routing } from "@/i18n/routing";
import AppLayout from "@/app/components/wrappers/appLayout/AppLayout";

const tajawal = Tajawal({
    variable: "--font-tajawal",
    subsets: ["latin"],
    weight: ["300", "400", "500", "700"],
});
const cinzel = Cinzel({
    variable: '--font-cinzel',
    weight: ['400', '700']
})
export const metadata: Metadata = {
    title: "وهيج | Waheej - العقارات في السعودية",
    description: "استثمر واسكن في السعودية: فرص عقارية مميزة - Real Estate In Saudi Arabia",
    keywords: "عقارات السعودية، استثمار عقاري، شقق للبيع، فلل للبيع، الرياض، جدة، real estate, Saudi Arabia",
    authors: [{ name: "Waheej" }],
    creator: "Waheej",
    publisher: "Waheej",
    metadataBase: new URL(process.env.NEXT_PUBLIC_SITE_URL || 'https://waheejsa.com'),
    alternates: {
        canonical: '/',
        languages: {
            'ar': '/ar',
            'en': '/en',
        },
    },
    openGraph: {
        type: "website",
        siteName: "Waheej",
        title: "وهيج | Waheej - العقارات في السعودية",
        description: "استثمر واسكن في السعودية: فرص عقارية مميزة",
        images: [
            {
                url: "/images/logo/logo-rect-light.svg",
                width: 1200,
                height: 630,
                alt: "Waheej Logo",
            },
        ],
    },
    twitter: {
        card: "summary_large_image",
        title: "وهيج | Waheej - العقارات في السعودية",
        description: "استثمر واسكن في السعودية: فرص عقارية مميزة",
        images: ["/images/logo/logo-rect-light.svg"],
    },
    robots: {
        index: true,
        follow: true,
        googleBot: {
            index: true,
            follow: true,
            'max-video-preview': -1,
            'max-image-preview': 'large',
            'max-snippet': -1,
        },
    },
    verification: {
        // google: 'YOUR_GOOGLE_VERIFICATION_CODE',
        // yandex: 'YOUR_YANDEX_VERIFICATION_CODE',
    },
};

export default async function RootLayout({
    children,
    params,
}: Readonly<{
    children: React.ReactNode;
    params: Promise<{ locale: string }>;
}>) {
    const { locale } = await params;
    if (!hasLocale(routing.locales, locale)) {
        notFound();
    }
    return (
        <html lang={locale} dir={locale === "ar" ? "rtl" : "ltr"}>
            <body className={`${tajawal.variable} ${cinzel.variable}  antialiased`}>
                <NextIntlClientProvider>
                    <AppLayout>{children}</AppLayout>
                </NextIntlClientProvider>
            </body>
        </html>
    );
}
