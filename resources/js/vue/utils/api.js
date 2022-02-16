import axios from 'axios';

import { API_BASE_URL } from '../shared/constants';

export const baseURL = `${API_BASE_URL}/api`;

export const http = axios.create({
    baseURL,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
});

export default http;
