import AxiosInstance from "./axiosInstance";

export const handleFetchRequest = async (url: string, method: "GET" | "POST" | "PUT" | "DELETE" = "GET", data: any = null, lang: string = "en") => {
    try {
        const res = await AxiosInstance({
            url,
            method,
            data,
            headers: { 
                "Accept-Language": lang,
                lang:lang
            },
        });
        
        return res.data;
    } catch (error: any) {
        throw error?.response?.data?.data?.errors;
    }
};
