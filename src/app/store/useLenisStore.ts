    // store/useLenisStore.ts
    import Lenis from "lenis";
    import { create } from "zustand";

    type LenisStore = {
        lenis: Lenis | null;
        setLenis: (lenis: Lenis) => void;
    };

    export const useLenisStore = create<LenisStore>((set) => ({
        lenis: null,
        setLenis: (lenis) => set({ lenis }),
    }));
