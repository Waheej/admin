import { NextConfig } from "next";
import createNextIntlPlugin from "next-intl/plugin";

const nextConfig: NextConfig = {
    output: 'standalone',
    images: {
        domains: ["admin.waheejsa.com"],
    },
};

const withNextIntl = createNextIntlPlugin();
export default withNextIntl(nextConfig);
