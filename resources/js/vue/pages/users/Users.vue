<template>
    <div>
        <v-client-table
            v-if="tableData"
            :data="tableData"
            :columns="columns"
            :options="options"
            class="p-6"
            @row-click="onRowClick"
        >
            <div slot="afterFilterWrapper" class="flex justify-end items-center pr-3" style="width: 100%">
                <button
                    v-if="mode === null"
                    @click="handleAdd"
                    class="mr-3 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                </button>
                <button
                    v-if="mode === null"
                    @click="handleDelete"
                    class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <font-awesome-icon icon="fa-solid fa-trash-can" />
                </button>
                <div v-if="mode === 'delete'" class="pr-3">Please select a user to {{ mode }}!</div>
                <button
                    v-if="mode === 'delete'"
                    @click="handleDone"
                    class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <font-awesome-icon icon="fa-solid fa-ban" />
                </button>
            </div>
        </v-client-table>
        <loading
            :active="isLoading"
            :is-full-page="true"
        />
        <t-modal
            v-model="showAdd"
            name="AddUser"
            header="Add New User"
            @closed="handleModalCancel"
        >
            <span v-if="errors.name" class="text-xs text-red-700">{{ errors.name }}</span>
            <input
                v-model="formAdd.name"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="name"
                autocomplete="name"
                placeholder="Full Name"
            />
            <span v-if="errors.email" class="text-xs text-red-700">{{ errors.email }}</span>
            <input
                v-model="formAdd.email"
                type="email"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                autocomplete="email"
                required
                name="email"
                placeholder="Email"
            />
            <span v-if="errors.password" class="text-xs text-red-700">{{ errors.password }}</span>
            <input
                v-model="formAdd.password"
                type="password"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Password"
            />
            <span v-if="errors.password_confirmation" class="text-xs text-red-700">{{ errors.password_confirmation }}</span>
            <input
                v-model="formAdd.password_confirmation"
                type="password"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="password_confirmation"
                placeholder="Confirm Password"
            />
            <template v-slot:footer>
                <div class="flex justify-between">
                    <button
                        @click="handleModalCancel"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                    <button
                        @click="handleModalAddSave"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Save
                    </button>
                </div>
            </template>
        </t-modal>
        <t-modal
            v-model="showDelete"
            name="DeleteUser"
            header="Delete User"
            @closed="handleModalCancel"
        >
            <div>Are you sure you want to delete this user?</div>
            <div>{{ deleteUser.id }}</div>
            <div>{{ deleteUser.name }}</div>
            <div>{{ deleteUser.email }}</div>
            <template v-slot:footer>
                <div class="flex justify-between">
                    <button
                        @click="handleModalCancel"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                    <button
                        @click="handleModalDeleteConfirm"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Yes
                    </button>
                </div>
            </template>
        </t-modal>
    </div>
</template>

<script>
import * as service from './users.service';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import { getItem } from '../../shared/utils/sessionStorage';

export default {
    name: 'Users',
    components: {
        Loading
    },
    data() {
        return {
            formAdd: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            deleteUser: {
                id: 0,
                name: '',
                email: ''
            },
            tableData: null,
            current: 1,
            pages: 1,
            isLoading: false,
            mode: null,
            options: {
                // see the options API
            },
            columns: ['id', 'name', 'email'],
            showAdd: false,
            showDelete: false
        }
    },
    async created() {
        await this.getRows();
    },
    methods: {
        async getRows() {
            this.isLoading = true;

            await service.getUsers(this.current).then(data => {
                this.isLoading = false;
                this.tableData = data.data;
                this.pages = data.meta.total;
            });
        },
        onRowClick(e) {
            if (this.mode === 'delete' && getItem('user').id !== e.row.id) {
                const _this = this;
                Object.keys(this.deleteUser).forEach(function(key) {
                    this.deleteUser[key] = e.row[key];
                });
                this.showDelete = true;

            }
        },
        handleDelete() {
            this.mode = 'delete'
        },
        handleAdd() {
            this.mode = 'add'
            this.showAdd = true;
        },
        handleDone() {
            this.mode = null
        },
        handleModalCancel() {
            this.mode = null;
            this.showDelete = false;
            this.showAdd = false;
        },
        handleModalAddSave() {
            this.isLoading = true;
            const _this = this;
            Object.keys(this.errors).forEach(function(key) {
                _this.errors[key] = null;
            });

            service.addUser(this.formAdd).then(data => {
                this.isLoading = false;
                this.tableData = data.data;
                this.pages = data.meta.total;
                this.handleModalCancel();
            }).catch(err => {
                Object.keys(err.response.data).forEach(function(key) {
                    _this.errors[key] = err.response.data[key][0];
                });
                this.isLoading = false;
            });
        },
        handleModalDeleteConfirm() {
            this.isLoading = true;
            service.deleteUser(this.deleteUser.id).then(data => {
                this.isLoading = false;
                this.tableData = data.data;
                this.pages = data.meta.total;
                this.handleModalCancel();
            }).catch(err => {
                this.isLoading = false;
            });
        }
    }
};
</script>

<style lang="scss">

</style>
