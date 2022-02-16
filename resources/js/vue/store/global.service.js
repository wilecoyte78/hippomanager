import { http } from '../shared/utils';

/**
* Apply all middleware logic
* Transform request (if required)
* Transform response (if required)
*/

export async function logIn(data) {
    const resp = await http.post('/login', data);

    return resp.data;
}

export async function createAccount(data) {
    const resp = await http.post('/register', data);

    return resp.data;
}

export async function checkLoggedIn() {
    const resp = await http.get('/user');

    return resp.data;
}

export async function logOut() {
    const resp = await http.post('/logout');

    return resp.data;
}
