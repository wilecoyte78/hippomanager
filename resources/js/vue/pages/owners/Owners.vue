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
            header="Add New Owner"
            @closed="handleModalCancel"
        >
            <span v-if="errors.first_name" class="text-xs text-red-700">{{ errors.first_name }}</span>
            <input
                v-model="formAdd.first_name"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="name"
                autocomplete="first_name"
                placeholder="First Name"
            />
            <span v-if="errors.last_name" class="text-xs text-red-700">{{ errors.last_name }}</span>
            <input
                v-model="formAdd.last_name"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                autocomplete="last_name"
                required
                name="last_name"
                placeholder="Last Name"
            />
            <span v-if="errors.phone" class="text-xs text-red-700">{{ errors.phone }}</span>
            <input
                v-model="formAdd.phone"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="phone"
                required
                autocomplete="phone"
                placeholder="Phone"
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
            name="deleteOwner"
            header="Delete User"
            @closed="handleModalCancel"
        >
            <div>Are you sure you want to delete this owner?</div>
            <div>{{ deleteOwner.id }}</div>
            <div>{{ deleteOwner.first_name }}</div>
            <div>{{ deleteOwner.last_name }}</div>
            <div>{{ deleteOwner.phone }}</div>
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
import * as service from './owners.service';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: 'Owners',
    components: {
        Loading
    },
    data() {
        return {
            formAdd: {
                first_name: '',
                last_name: '',
                phone: ''
            },
            errors: {
                first_name: null,
                last_name: null,
                phone: null
            },
            deleteOwner: {
                id: 0,
                first_name: '',
                last_name: '',
                phone: ''
            },
            tableData: null,
            current: 1,
            pages: 1,
            isLoading: false,
            mode: null,
            options: {
                // see the options API
            },
            columns: ['id', 'first_name', 'last_name', 'phone'],
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

            await service.getOwners(this.current).then(data => {
                this.isLoading = false;
                this.tableData = data.data;
                this.pages = data.meta.total;
            });
        },
        onRowClick(e) {
            if (this.mode === 'delete') {
                const _this = this;
                Object.keys(this.deleteOwner).forEach(function(key) {
                    this.deleteOwner[key] = e.row[key];
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

            service.addOwner(this.formAdd).then(data => {
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
            service.deleteOwner(this.deleteOwner.id).then(data => {
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
