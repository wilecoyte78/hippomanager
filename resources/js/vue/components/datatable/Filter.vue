<template>
    <div class="VueTables__search-field">
        <input
            class="block border border-grey-light w-full p-3 rounded mb-4"
            type="text"
            ref="filter"
            :placeholder="props.display('filterPlaceholder')"
            @keyup="e=>props.search(props.opts.debounce)(e)"
            :id="`VueTables__search_${props.id}`"
        />
    </div>
</template>

<script>
export default {
    name: "Filter",
    props: ['props'],
    methods: {
        focus() {
            this.$refs.filter.focus()
        },
        blur() {
            this.$refs.filter.blur()
        }
    }
}
</script>
