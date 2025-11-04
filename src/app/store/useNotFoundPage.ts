import { create } from 'zustand';

interface NotFoundPageStore {
    isNotFoundPage: boolean;
    isErrorPage: boolean;
    setIsNotFoundPage: (value: boolean) => void;
    setIsErrorPage: (value: boolean) => void;
}

const useNotFoundPage = create<NotFoundPageStore>((set) => ({
    isNotFoundPage: false,
    isErrorPage: false,
    setIsNotFoundPage: (value: boolean) => set({ isNotFoundPage: value }),
    setIsErrorPage: (value: boolean) => set({ isErrorPage: value }),
}));

export default useNotFoundPage;

