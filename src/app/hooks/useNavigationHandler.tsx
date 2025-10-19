"use client";
import { useEffect, useRef } from "react";
import { usePathname, useSearchParams } from "next/navigation";
import useToggleMenu from "@/app/store/useToggleMenu";

export const useNavigationHandler = () => {
    const pathname = usePathname();
    const search = useSearchParams()?.toString() ?? "";

    const { isOpen, closeMenu } = useToggleMenu();

    const lastPath = useRef(pathname + "?" + search);
    const isFirstLoad = useRef(true);

    useEffect(() => {
        const handleClick = (e: MouseEvent) => {
            const link = (e.target as HTMLElement).closest("a") as HTMLAnchorElement | null;
            if (!link) return;

            const href = link.getAttribute("href");
            if (!href) return;

            // أقفل المنيو فوراً
            if (isOpen) {
                closeMenu();
            }

            // لو نفس الصفحة الحالية: لا تفعل اللودر
            if (href === lastPath.current) return;

            // تجاهل أول تحميل (Refresh)
            if (isFirstLoad.current) {
                isFirstLoad.current = false;
                lastPath.current = href;
                return;
            }

            // سيترك تشغيل اللودر لاعتراض التنقل المركزي
            lastPath.current = href;
        };

        document.addEventListener("click", handleClick);
        return () => document.removeEventListener("click", handleClick);
    }, [isOpen, closeMenu]);
};
