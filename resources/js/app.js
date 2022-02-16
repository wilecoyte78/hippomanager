require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { VuejsDatatableFactory } from 'vuejs-datatable';
import { ClientTable } from 'vue-tables-2-premium';
import VueTailwind from 'vue-tailwind'

import router from './vue/router/index';
import store from './vue/store/index';
import App from './vue/App';
import { Pagination, Filter, Main } from './vue/components/datatable';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faTrashCan, faCirclePlus, faBan } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import TModal from 'vue-tailwind/dist/t-modal';

const settings = {
    't-modal': {
        component: TModal,
        props: {
            fixedClasses: {
                overlay: 'z-40  overflow-auto scrolling-touch left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50',
                wrapper: 'relative mx-auto z-50 max-w-lg px-3 py-12',
                modal: 'overflow-visible relative  rounded',
                body: 'p-3',
                header: 'border-b p-3 rounded-t',
                footer: ' p-3 rounded-b',
                close: 'flex items-center justify-center rounded-full absolute right-0 top-0 -m-3 h-8 w-8 transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50'
            },
            classes: {
                overlay: 'bg-black',
                wrapper: '',
                modal: 'bg-white shadow',
                body: 'p-3',
                header: 'border-gray-100',
                footer: 'bg-gray-100',
                close: 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                closeIcon: 'fill-current h-4 w-4',
                overlayEnterClass: 'opacity-0',
                overlayEnterActiveClass: 'transition ease-out duration-100',
                overlayEnterToClass: 'opacity-100',
                overlayLeaveClass: 'opacity-100',
                overlayLeaveActiveClass: 'transition ease-in duration-75',
                overlayLeaveToClass: 'opacity-0',
                enterClass: '',
                enterActiveClass: '',
                enterToClass: '',
                leaveClass: '',
                leaveActiveClass: '',
                leaveToClass: ''
            },
            variants: {
                danger: {
                    overlay: 'bg-red-100',
                    header: 'border-red-50 text-red-700',
                    close: 'bg-red-50 text-red-700 hover:bg-red-200 border-red-100 border',
                    modal: 'bg-white border border-red-100 shadow-lg',
                    footer: 'bg-red-50'
                }
            }
        }
    }
};

Vue.use( VueRouter );
Vue.use( VuejsDatatableFactory );
Vue.use( VueTailwind, settings );

/* add icons to the library */
library.add(faTrashCan, faCirclePlus, faBan);
/* add font awesome icon component */
Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

let options = {};
let useVuex = false;
let theme = "tailwind";
let template = {
    pagination: Pagination,
    genericFilter: Filter,
    dataTable: Main
};
Vue.use( ClientTable, options, useVuex, theme, template );

new Vue({
    el: '#app',
    router,
    store,
    components: { App }
});
