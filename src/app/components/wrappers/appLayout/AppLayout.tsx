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
import { useInitialLoader } from "@/app/store/useInitialLoader";
import React, { Fragment, ReactNode, useEffect, useRef } from "react";
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
    const { hide: hideInitialLoader, setProgress, show: showLoader } = useInitialLoader();
    const isFirstLoad = useRef(true);

    // ✅ بس في أول مرة (initial page load)
    useEffect(() => {
        if (isFirstLoad.current) {
            isFirstLoad.current = false;
            showLoader();
            setProgress(0);

            let progress = 0;
            const interval = setInterval(() => {
                progress += 12;
                if (progress <= 85) {
                    setProgress(progress);
                } else {
                    clearInterval(interval);
                }
            }, 100);

            setTimeout(() => {
                setProgress(100);
                setTimeout(() => {
                    hideInitialLoader();
                }, 500);
            }, 1500);

            return () => clearInterval(interval);
        }
    }, []);

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
