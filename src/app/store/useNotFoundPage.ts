import { create } from 'zustand';

interface NotFoundPageStore {
    isNotFoundPage: boolean;
    setIsNotFoundPage: (value: boolean) => void;
}

const useNotFoundPage = create<NotFoundPageStore>((set) => ({
    isNotFoundPage: false,
    setIsNotFoundPage: (value: boolean) => set({ isNotFoundPage: value }),
}));

export default useNotFoundPage;

