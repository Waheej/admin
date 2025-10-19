"use client";

import { create } from "zustand";

type InitialLoaderState = {
    visible: boolean;
    progress: number;
    show: () => void;
    hide: () => void;
    setProgress: (p: number) => void;
};

export const useInitialLoader = create<InitialLoaderState>((set) => ({
    visible: true,
    progress: 0,
    show: () => set({ visible: true }),
    hide: () => set({ visible: false, progress: 100 }),
    setProgress: (p) => set({ progress: Math.max(0, Math.min(100, p)) }),
}));



