<script setup>

import {Link} from "@inertiajs/vue3";

const props = defineProps({
    routeName: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    }
})

</script>

<template>
    <Link :href="route(props.routeName)" class="text-blue-500">{{label}}</Link>
</template>
