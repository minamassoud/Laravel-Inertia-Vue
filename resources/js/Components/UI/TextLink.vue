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
    <Link :href="route(props.routeName)"
          class="text-indigo-500 hover:text-indigo-600 font-medium underline dark:text-indigo-400 dark:hover:text-indigo-500">
        {{ label }}
    </Link>
</template>
