// app/store/useLoadingRoutePage.ts
"use client";

import { create } from "zustand";

type State = {
    isTransitioning: boolean;
    exitRequested: boolean;
    isLanguageSwitch: boolean; // ✅ flag لتجاهل الأنيميشن في حالة تغيير اللغة
    startTransition: () => Promise<void>;
    resolveEntry: () => void;
    requestExit: () => void;
    finishTransition: () => void;
    setLanguageSwitch: (isSwitch: boolean) => void; // ✅ دالة لتعيين flag
    // internal
    _resolve?: (() => void) | null;
    _entryPromise?: Promise<void> | null;
};

export const useLoadingRoutePage = create<State>((set, get) => ({
    isTransitioning: false,
    exitRequested: false,
    isLanguageSwitch: false, // ✅ initial value
    _resolve: null,
    _entryPromise: null,

    startTransition: () => {
        // لو انت بالفعل في تَرانزيشن، ارجع البروبميز الحالي
        if (get().isTransitioning) return get()._entryPromise || Promise.resolve();

        let resolver: (() => void) | null = null;
        const p = new Promise<void>((resolve) => {
            resolver = resolve;
        });

        set({
            isTransitioning: true,
            exitRequested: false,
            _resolve: resolver,
            _entryPromise: p,
        });

        return p;
    },

    resolveEntry: () => {
        const r = get()._resolve;
        if (r) {
            r();
            set({ _resolve: null, _entryPromise: null });
        }
    },

    requestExit: () => {
        set({ exitRequested: true });
    },

    finishTransition: () => {
        set({ isTransitioning: false, exitRequested: false, isLanguageSwitch: false });
    },

    setLanguageSwitch: (isSwitch: boolean) => {
        set({ isLanguageSwitch: isSwitch });
    },
}));
