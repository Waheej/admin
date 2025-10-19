"use client";
import { useEffect, useRef } from "react";
import { useRouter } from "next/navigation";
import { useLoadingRoutePage } from "@/app/store/useLoadingRoutePage";
import { routing } from "@/i18n/routing";

import useToggleMenu from "@/app/store/useToggleMenu";

export default function NavigationInterceptor() {
    const router = useRouter();
    const startTransition = useLoadingRoutePage((s) => s.startTransition);
    const requestExit = useLoadingRoutePage((s) => s.requestExit);
    const { isOpen: isMenuOpen } = useToggleMenu();

    const lastPath = useRef<string>("");

    useEffect(() => {
        lastPath.current = window.location.pathname + window.location.search + window.location.hash;
    }, []);

    useEffect(() => {
        const handler = async (e: MouseEvent) => {
            try {
                if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

                const target = (e.target as HTMLElement)?.closest?.("a") as HTMLAnchorElement | null;
                if (!target) return;

                const href = target.getAttribute("href");
                if (!href) return;
                if (href === "#" || href === "") return; // ignore placeholder links

                if (target.target === "_blank" || target.hasAttribute("download")) return;
                if (href.startsWith("mailto:") || href.startsWith("tel:") || href.startsWith("http")) {
                    const url = new URL(href, window.location.href);
                    if (url.origin !== window.location.origin) return;
                }

                const fullTarget = new URL(href, window.location.href);
                const normalizePath = (p: string) => (p.endsWith("/") && p !== "/" ? p.slice(0, -1) : p);
                const getCurrentLocale = (): string => {
                    const htmlLang = document.documentElement.lang;
                    if (routing.locales.includes(htmlLang as any)) return htmlLang;
                    const seg = window.location.pathname.split("/")[1];
                    return routing.locales.includes(seg as any) ? seg : routing.defaultLocale;
                };
                const stripLocale = (p: string) => {
                    const first = p.split("/")[1];
                    if (routing.locales.includes(first as any)) {
                        const rest = p.slice(first.length + 1) || "/";
                        return rest.startsWith("/") ? rest : `/${rest}`;
                    }
                    return p || "/";
                };

                // If href is '/', resolve to current locale root path
                if (href === "/") {
                    const curLoc = getCurrentLocale();
                    fullTarget.pathname = `/${curLoc}`;
                }
                const sortSearch = (s: string) => {
                    if (!s) return "";
                    const sp = new URLSearchParams(s);
                    const entries = Array.from(sp.entries()).sort(([a],[b]) => a.localeCompare(b));
                    const sorted = new URLSearchParams(entries);
                    const qs = sorted.toString();
                    return qs ? `?${qs}` : "";
                };
                const targetFull = normalizePath(fullTarget.pathname) + sortSearch(fullTarget.search) + fullTarget.hash;
                const currentFull = normalizePath(window.location.pathname) + sortSearch(window.location.search) + window.location.hash;

                // لو نفس الصفحة الحالية نسمح بالتنقل الطبيعي
                const isSamePage = targetFull === currentFull || (stripLocale(targetFull) === stripLocale(currentFull));
                if (isSamePage) {
                    lastPath.current = targetFull;
                    return;
                }

                // ✅ تحقق من تغيير اللغة فقط (نفس المسار بدون اللغة)
                const isLanguageSwitch = stripLocale(normalizePath(fullTarget.pathname)) === stripLocale(normalizePath(window.location.pathname))
                    && sortSearch(fullTarget.search) === sortSearch(window.location.search);
                
                if (isLanguageSwitch) {
                    // تغيير لغة فقط - نسمح بالتنقل العادي بدون أنيميشن
                    lastPath.current = targetFull;
                    return;
                }

                // لو نفس المسار وتغيير هاش فقط → خليه سلوك طبيعي بدون لودر
                const isSamePathOnlyHashChange = (
                    normalizePath(fullTarget.pathname) === normalizePath(window.location.pathname) || stripLocale(normalizePath(fullTarget.pathname)) === stripLocale(normalizePath(window.location.pathname))
                ) && sortSearch(fullTarget.search) === sortSearch(window.location.search);
                if (isSamePathOnlyHashChange) {
                    lastPath.current = targetFull;
                    return;
                }

                // لو المنيو مفتوح: لسه هنشغل اللودر لكن بعد ما نقفل المنيو
                // نواصل الاعتراض وتشغيل اللودر بشكل مركزي

                // خلاف ذلك → شغل اللودر
                e.preventDefault();
                lastPath.current = targetFull;

                await startTransition();
                await router.push(targetFull);
                requestExit();
            } catch (err) {
                // Navigation error handled silently
            }
        };

        document.addEventListener("click", handler, true);
        return () => document.removeEventListener("click", handler, true);
    }, [router, startTransition, requestExit, isMenuOpen]);

    return null;
}

