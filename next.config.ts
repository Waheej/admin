import { NextConfig } from "next";
import createNextIntlPlugin from "next-intl/plugin";

const nextConfig: NextConfig = {
    images: {
        domains: ["admin.waheejsa.com", "127.0.0.1"],
    },
};

const withNextIntl = createNextIntlPlugin();
export default withNextIntl(nextConfig);
