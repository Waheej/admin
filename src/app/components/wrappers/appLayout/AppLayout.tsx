"use client";
import GeneralPopUp from "@/app/components/common/generalPopUp/GeneralPopUp";
import InitialLoadingPage from "@/app/components/ui/InitialLoadingPage";
import TargetCursor from "@/app/components/module/targetCursor/TargetCursor";
import Footer from "@/app/components/navigation/Footer";
import Menu from "@/app/components/navigation/Menu";
import Navbar from "@/app/components/navigation/Navbar";
import NavigationInterceptor from "@/app/components/NavigationInterceptor";
import LoadingRoutePage from "@/app/components/ui/LoadingRoutePage.tsx/LoadingRoutePage";
import GeneralSmoother from "@/app/components/wrappers/generalSmoother/GeneralSmoother";
import { useNavigationHandler } from "@/app/hooks/useNavigationHandler";
import React, { Fragment, ReactNode } from "react";
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';

type AppLayoutProps = {
    children: ReactNode;
};

// ✅ QueryClient خارج الـ component عشان ميتعملش create كل مرة
const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnWindowFocus: false, // ✅ معطّل refetch لما window يرجع focus
            refetchOnMount: false, // ✅ معطّل refetch لما component يتعمل mount
            refetchOnReconnect: false, // ✅ معطّل refetch لما الإنترنت يرجع
            retry: 2, // ✅ يحاول مرتين بس لو فشل
            staleTime: 1000 * 60 * 5, // ✅ البيانات تفضل fresh لمدة 5 دقائق
        },
    },
});

const AppLayout: React.FC<AppLayoutProps> = ({ children }) => {
    useNavigationHandler();
    return (
        <Fragment>
            <InitialLoadingPage />
            <GeneralSmoother>
                <QueryClientProvider client={queryClient}>
                    <NavigationInterceptor />
                    <LoadingRoutePage />
                    <Navbar />
                    <Menu />
                    <GeneralPopUp />
                    <main className=" p-4 flex flex-col gap-8">{children}</main>
                    <Footer />
                </QueryClientProvider>
            </GeneralSmoother>
        </Fragment>
    );
};

export default AppLayout;
