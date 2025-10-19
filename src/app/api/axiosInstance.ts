import axios from "axios";

const AxiosInstance = axios.create({
    baseURL: process.env.NEXT_PUBLIC_API_URL_STAGING,
    headers: { "Content-Type": "application/json" },
});

AxiosInstance.defaults.headers.common.Accept = "application/json";

export default AxiosInstance;
