<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h1 class="mt-6 text-3xl text-center">Sign in to your account</h1>
            </div>
            <div class="text-black w-full">
                <input
                    v-model="email"
                    type="email"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    autocomplete="email"
                    required
                    name="email"
                    id="email-address"
                    placeholder="Email" />

                <input
                    v-model="password"
                    type="password"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    name="password"
                    required
                    id="password"
                    autocomplete="current-password"
                    placeholder="Password" />
            </div>
            <div>
                <button @click="handleLogIn" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>
        </div>
        <loading
            :active="isLoading"
            :is-full-page="true"
        />
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import ns from '../store/namespaces';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: 'Login',
    components: {
        Loading
    },
    computed: {
        ...mapState(ns.global, ['isLoggedIn']),
    },
    data() {
        return {
            email: '',
            password: '',
            isLoading: false
        };
    },
    methods: {
        ...mapActions(ns.global, ['logIn']),
        handleLogIn() {
            this.isLoading = true;

            this.logIn({
                email: this.email,
                password: this.password
            }).then(() => {
                this.$router.push('/users');
                this.isLoading = false
            }).catch(err => {
                this.isLoading = false
            });
        }
    }
}
</script>
