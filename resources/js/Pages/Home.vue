<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import Card from "../Components/Card.vue";
import PaginationLinks from "../Components/PaginationLinks.vue";
import Container from "../Components/Container.vue";
import InputField from "../Components/UI/InputField.vue";
import {watch} from "vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";


const props = defineProps({
    listings: Object,
    filters: Object,
})

const form = useForm({
    search: props.filters.search
})

const filterSearch = () => {
    router.get(route('home'),
        {
            search: form.search,
            user: props.filters.user,
            tag: props.filters.tag,
        },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
}

const valueByKey = (key, value) => {
    if (key === 'user') {
        return props.listings.data.find(l => l.user_id === Number(value)).user.name
    }

    return value
}

const clearFilter = (key) => {
    delete props.filters[key]
    if (key === 'search') form.search = "";

    router.get(route('home'),
        {
            ...props.filters
        },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
}

watch(() => form.search, (newValue) => {
    if (newValue === '') {
        clearFilter('search')
    }
}, {immediate: true})

</script>

<template>
    <head title="Listings"/>

    <section class="flex flex-row justify-between items-center">
        <div class="flex flex-row items-center gap-2">
            <template v-for="(value, key) in filters" :key="key">
                <button v-if="value" class="pullet-btn-x" @click="clearFilter(key)">
                    <span>{{ valueByKey(key, value) }}</span>
                    <font-awesome-icon icon="xmark"/>
                </button>
            </template>
        </div>
        <div class="mb-4 w-64">
            <form @submit.prevent="filterSearch">
                <InputField v-model="form.search" icon="magnifying-glass" label="" placeholder="Search..."
                            type="search"/>
            </form>
        </div>
    </section>

    <div v-if="Object.keys(listings.data).length">

        <div class="grid grid-col-3 gap-4">
            <div v-for="listing in props.listings.data" :key="listing.id">
                <Card :filters="props.filters" :listing="listing"/>
            </div>
        </div>

        <div class="mt-4">
            <pagination-links :from="listings.from" :links="listings.links" :to="listings.to" :total="listings.total"/>
        </div>

    </div>
    <div v-else>
        <container class="flex items-center justify-center w-1/2">
            There are no Listings here
        </container>
    </div>


</template>
