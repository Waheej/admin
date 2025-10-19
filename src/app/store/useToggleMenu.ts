import { create } from "zustand";

type State = {
    isOpen: boolean;
    toggle: () => void;
    closeMenu: () => void;
};

const useToggleMenu = create<State>((set) => ({
    isOpen: false,
    toggle: () => set((state) => ({ isOpen: !state.isOpen })),
    closeMenu: () => set({ isOpen: false }),
}));

export default useToggleMenu;
