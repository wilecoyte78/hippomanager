import Vue from 'vue';
import Vuex from 'vuex';
import ns from './namespaces';
import global from './global.module';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        [ns.global]: global
    }
});
