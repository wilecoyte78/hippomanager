import { http } from '../../shared/utils';

const url = '/patients';

export async function getPatients(page) {
    const resp = await http.get(`${url}?page=${page}`);
    return resp.data;
}

export async function addPatient(data) {
    const resp = await http.post(url, data);
    return resp.data;
}

export async function deletePatient(id) {
    const resp = await http.delete(`${url}/${id}`);
    return resp.data;
}

export async function getOwners() {
    const resp = await http.get('references/owners');
    return resp.data;
}
