import { create } from "zustand";

type TGeneralPopUp = {
    component: React.ReactNode | null;
    type: string | null;
    setChildren: (component: React.ReactNode, type: string) => void;
};
const useGeneralPopUp = create<TGeneralPopUp>((set) => ({
    component: null,
    type: null,
    setChildren: (component, type) =>
        set({
            component,
            type,
        }),
}));

export default useGeneralPopUp
