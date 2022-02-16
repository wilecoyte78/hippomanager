import axios from 'axios';

import { API_BASE_URL, sessionStorageTokenName } from '../constants';
import { getItem } from './sessionStorage';

export const baseURL = `${API_BASE_URL}/api`;

export function getAuthorization() {
    const items = ['Bearer', getItem(sessionStorageTokenName)];
    return items.join(' ');
}

export const http = axios.create({
    baseURL,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
});

http.interceptors.request.use(req => {
    // Make sure to not set Authorization if the token is not present.
    if (getAuthorization().length > 7) {
        req.headers.Authorization = getAuthorization();
    }

    return req;
});

export default http;
