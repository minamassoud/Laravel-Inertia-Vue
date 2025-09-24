<script setup>
import {Head} from "@inertiajs/vue3";
import Card from "../Components/Card.vue";


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
    </div>

</template>
