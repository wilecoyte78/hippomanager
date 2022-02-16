<template>
    <v-pagination
        v-model="props.page"
        :page-count="props.totalPages"
        @input="page => props.setPage(page)"
        :classes="tailwindClasses"
    />
</template>

<script>
import vPagination from 'vue-plain-pagination'

export default {
    name: "Pagination",
    components: {
        vPagination
    },
    props: ['props'],
    data() {
        return {
            tailwindClasses: {
                ul: 'tailwind-pagination flex justify-center mt-4',
                li: 'flex',
                button: 'h-10 px-5 bg-white border border-r-0 border-gray-600 hover:bg-gray-100',
                buttonActive: 'text-white bg-gray-600 hover:text-gray-600',
            }
        }
    }
}
</script>

<style lang="scss">
.tailwind-pagination {
    li:last-child {
        border-right-width: 1px !important;
        border-color: rgb(75 85 99 / var(--tw-border-opacity));
    }
    .pagination-item--disable button {
        color: rgb(75 85 99 / var(--tw-text-opacity));
    }
}
</style>
