<script setup>

import {computed} from "vue";

const model = defineModel()

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    error: {
        default: ""
    }
})

</script>

<template>
    <div>
        <div class="flex items-center gap-2">
            <input
                :id="props.name"
                v-model="model"
                class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700"
                type="checkbox"
            >
            <label :for="props.name"
                   class="block text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                <slot/>
            </label>
        </div>

        <div v-if="error" class="text-xs text-red-500 pl-2 mt-1">{{ error }}</div>
    </div>
</template>
