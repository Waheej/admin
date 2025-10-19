import HomePage from "@/app/components/pages/HomePage";
import { generalMetaTag } from "@/app/helper/generalMetaTag";
import { Metadata } from "next";

// export async function generateMetadata({ params }: { params: { locale: string } }): Promise<Metadata> {
//     const lang = params.locale || "en";
//     return await generalMetaTag("homePage", lang);
// }
export default function page() {
    return <HomePage />;
}
