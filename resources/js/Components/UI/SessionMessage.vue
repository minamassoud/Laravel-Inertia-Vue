<script setup>

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const props = defineProps({
    status: {
        type: String,
        default: ""
    }
})
</script>

<template>
    <div v-if="props.status" class="bg-yellow-500/20 text-yellow-300 border border-yellow-500/40 p-3 rounded
                mb-6">
        <font-awesome-icon icon="triangle-exclamation"/> &nbsp;&nbsp;
        {{ props.status }}
    </div>
</template>
