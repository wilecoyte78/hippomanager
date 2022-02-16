import { http } from '../../shared/utils';

const url = '/users';

export async function getUsers(page) {
    const resp = await http.get(`${url}?page=${page}`);
    return resp.data;
}

export async function addUser(data) {
    const resp = await http.post(url, data);
    return resp.data;
}

export async function deleteUser(id) {
    const resp = await http.delete(`${url}/${id}`);
    return resp.data;
}
