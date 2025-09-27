<script setup>
import {Head} from "@inertiajs/vue3";
import Card from "../Components/Card.vue";
import PaginationLinks from "../Components/PaginationLinks.vue";


const props = defineProps({
    listings: Object
})

console.log(props.listings)
</script>

<template>
    <head title="Listings"/>

    <div v-if="Object.keys(listings.data).length">

        <div class="grid grid-col-3 gap-4">
            <div v-for="listing in props.listings.data" :key="listing.id">
                <Card :listing="listing"/>
            </div>
        </div>

        <div class="mt-4">
            <pagination-links :from="listings.from" :links="listings.links" :to="listings.to" :total="listings.total"/>
        </div>


    </div>

</template>
