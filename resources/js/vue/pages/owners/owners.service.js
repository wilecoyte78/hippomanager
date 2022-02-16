import { http } from '../../shared/utils';

const url = '/owners';

export async function getOwners(page) {
    const resp = await http.get(`${url}?page=${page}`);
    return resp.data;
}

export async function addOwner(data) {
    const resp = await http.post(url, data);
    return resp.data;
}

export async function deleteOwner(id) {
    const resp = await http.delete(`${url}/${id}`);
    return resp.data;
}
