import Login from '../pages/Login';
import Register from '../pages/Register';
import Users from '../pages/users/Users';
import Owners from '../pages/owners/Owners';
import Patients from '../pages/patients/Patients';

const routes = [
    {
        path: '',
        component: Login,
        name: 'login'
    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '/users',
        component: Users,
        name: 'users'
    },
    {
        path: '/owners',
        component: Owners,
        name: 'owners'
    },
    {
        path: '/patients',
        component: Patients,
        name: 'patients'
    }
];

export default routes;
