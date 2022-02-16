import * as service from './global.service';
import { setItem, getItem } from '../shared/utils/sessionStorage';
import { sessionStorageTokenName } from '../shared/constants';

/**
 * Default State
 */
const defaultState = () => ({
    isLoggedIn: false,
    authToken: getItem(sessionStorageTokenName) || null
});

/**
 * Notes:
 * - mapState is an elegant solution for directly mapping store data to a component
 * - Use getters only for non-trivial data manipulation using filter, map etc.,
 * - getters gets cached by default.  Never use parameterized getters.
 */
const getters = {};

/**
 * Notes:
 * - All state change needs to happen via mutations
 * - Mutation handler functions must be synchronous
 */
const mutations = {
    setIsLoggedIn(state, isLoggedIn) {
        state.isLoggedIn = isLoggedIn;
    },
    setAuthToken(state, token) {
        state.authToken = token;
    }
}

/**
 * Notes:
 * - Any Service call or async actions whose outcome need to be stored
 *   in Vuex state will be handled here
 * - context refers to the following
 * {
 *   state,      // same as module state
 *   rootState,  // same as `store.state`
 *   commit,     // same as `store.commit`
 *   dispatch,   // same as `store.dispatch`
 *   getters,    // same as local getters
 *   rootGetters // same as `store.getters`
 *  }
 */
const actions = {
    async logIn({ commit }, data) {
        const resp = await service.logIn(data);
        const authToken = resp.token;

        if (authToken) {
            setItem(sessionStorageTokenName, resp.token);
            setItem('user', resp.user);
            commit('setAuthToken', resp.token);
            commit('setIsLoggedIn', true);
        }
    },
    async logOut({ commit }) {
        const resp = await service.logOut();

        setItem(sessionStorageTokenName, null);
        setItem('user', null);
        commit('setAuthToken', null);
        commit('setIsLoggedIn', false);
    },
    async createAccount({ commit }, data) {
        const resp = await service.createAccount(data);
        const authToken = resp.token;

        if (authToken.token) {
            setItem(sessionStorageTokenName, resp.token);
            setItem('user', resp.user);
            commit('setAuthToken', resp.token);
            commit('setIsLoggedIn', true);
        }
    },
    async checkLoggedIn({ commit }) {
        const resp = await service.checkLoggedIn();
        setItem(sessionStorageTokenName, resp.token);
        setItem('user', resp.user);
        commit('setAuthToken', resp.token);
        commit('setIsLoggedIn', true);
    }
};

/**
 * Store
 */
export default {
    namespaced: true,
    state: defaultState,
    mutations,
    actions,
    getters
};
