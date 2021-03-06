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
            header="Add New Patient"
            @closed="handleModalCancel"
        >
            <span v-if="errors.name" class="text-xs text-red-700">{{ errors.name }}</span>
            <input
                v-model="formAdd.name"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="name"
                autocomplete="name"
                placeholder="Name"
            />
            <span v-if="errors.species" class="text-xs text-red-700">{{ errors.species }}</span>
            <input
                v-model="formAdd.species"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                autocomplete="species"
                required
                name="species"
                placeholder="Species"
            />
            <span v-if="errors.color" class="text-xs text-red-700">{{ errors.color }}</span>
            <input
                v-model="formAdd.color"
                type="text"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="color"
                required
                autocomplete="color"
                placeholder="Color"
            />
            <span v-if="errors.dob" class="text-xs text-red-700">{{ errors.dob }}</span>
            <input
                v-model="formAdd.dob"
                type="date"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="dob"
                placeholder="Date Of Birth"
            />
            <select
                v-model="formAdd.owner"
                class="block border border-grey-light w-full p-3 rounded mb-4"
                name="owner"
                @change="handleOwnerChange"
            >
                <option selected>Please Select An Owner!</option>
                <option
                    v-for="owner in owners"
                    :key="owner.id"
                    :value="owner.id"
                >
                    {{ owner.first_name }} {{ owner.last_name }}
                </option>
            </select>
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
            name="deletePatient"
            header="Delete User"
            @closed="handleModalCancel"
        >
            <div>Are you sure you want to delete this patient?</div>
            <div>{{ deletePatient.id }}</div>
            <div>{{ deletePatient.name }}</div>
            <div>{{ deletePatient.email }}</div>
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
import * as service from './patients.service';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: 'Patients',
    components: {
        Loading
    },
    data() {
        return {
            formAdd: {
                name: '',
                species: '',
                color: '',
                dob: '',
                owner: ''
            },
            errors: {
                name: null,
                species: null,
                color: null,
                dob: null,
                owner: null
            },
            deletePatient: {
                id: 0,
                name: '',
                species: '',
                color: '',
                dob: '',
                owner: ''
            },
            tableData: null,
            current: 1,
            pages: 1,
            isLoading: false,
            mode: null,
            options: {
                // see the options API
            },
            columns: ['id', 'species', 'color', 'dob', 'owner'],
            showAdd: false,
            showDelete: false,
            owners: null
        }
    },
    async created() {
        await this.getRows();
    },
    methods: {
        async getRows() {
            this.isLoading = true;

            await service.getPatients(this.current).then(async patients => {
                await service.getOwners().then(owners => {
                    this.owners = owners;
                    this.isLoading = false;
                    this.tableData = patients.data.map((value) => {
                        return {
                            id: value.id,
                            color: value.color,
                            dob: value.dob,
                            name: value.name,
                            owner: value.owner.first_name + ' ' + value.owner.last_name,
                            species: value.species
                        }
                    });
                    this.pages = patients.meta.total;
                });
            });
        },
        onRowClick(e) {
            if (this.mode === 'delete') {
                const _this = this;
                Object.keys(this.deletePatient).forEach(function(key) {
                    this.deletePatient[key] = e.row[key];
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

            service.addPatient(this.formAdd).then(data => {
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
            service.deletePatient(this.deletePatient.id).then(data => {
                this.isLoading = false;
                this.tableData = data.data;
                this.pages = data.meta.total;
                this.handleModalCancel();
            }).catch(err => {
                this.isLoading = false;
            });
        },
        handleOwnerChange(e) {
            this.formAdd.owner = e.target.value;
        }
    }
};
</script>

<style lang="scss">

</style>
