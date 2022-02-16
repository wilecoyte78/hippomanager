<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h1 class="mt-6 text-3xl text-center">Register for an account</h1>
            </div>
            <div class="text-black w-full">
                <input
                    v-model="full_name"
                    type="text"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    name="full_name"
                    autocomplete="full_name"
                    placeholder="Full Name"
                />
                <input
                    v-model="email"
                    type="email"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    autocomplete="email"
                    required
                    name="email"
                    placeholder="Email"
                />
                <input
                    v-model="password"
                    type="password"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />
                <input
                    v-model="password_confirmation"
                    type="password"
                    class="block border border-grey-light w-full p-3 rounded mb-4"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                />
            </div>
            <div>
                <button
                    @click="handleCreateAccount"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Create Account
                </button>
            </div>
            <div class="text-grey-dark mt-6">
                Already have an account?
                <router-link
                    to="/"
                    class="no-underline border-b border-blue text-blue"
                >
                    Log In
                </router-link>
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
    name: 'Register',
    components: {
        Loading
    },
    computed: {
        ...mapState(ns.global, ['isLoggedIn']),
    },
    data() {
        return {
            full_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            isLoading: false
        };
    },
    methods: {
        ...mapActions(ns.global, ['createAccount']),
        handleCreateAccount() {
            this.isLoading = true;

            this.createAccount({
                name: this.full_name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
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
