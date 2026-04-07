import axios from 'axios';
import { ref } from 'vue';

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_BASE_API_URL,
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
    }
});

export function useAPI() {
    const data = ref(null);
    const loading = ref(null);
    const error = ref(null);

    const request = async (url, options = {}) => {
        data.value = null;
        loading.value = null;
        error.value = null;

        try {
            loading.value = true;

            const response = await axiosInstance({
                url,
                ...options
            });

            data.value = response.data;
            return response.data;
        } catch (e) {
            error.value = 'Error request';
            throw new Error('Error request');
        } finally {
            loading.value = false;
        }
    }

    const get = async (url, id = null) => request(url + `/${(id) ? id : ''}`, { method: 'GET' });

    const post = async (url, data) => request(url, { method: 'POST', data });

    const destroy = async (url, id) => request(url + `/${id}`, { method: 'DELETE' });

    const put = async (url, data, id) => request(url + `/${id}`, { method: 'PUT', data });

    return {
        data,
        loading,
        get,
        post,
        destroy,
        put,
        request
    }
}