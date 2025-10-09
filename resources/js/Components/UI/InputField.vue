<script setup>

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {computed} from "vue";

const model = defineModel()

const props = defineProps({
    type: {
        required: false,
        type: String,
        default: "text"
    },
    disabled: {
        default: false
    },
    label: {
        type: String,
        required: true
    },
    placeholder: {
        default: "",
        type: String,
    },
    icon: String,
    autocomplete: {
        default: "off"
    },
    error: {
        default: ""
    }
})

const snakeCaseLabel = computed( () => props.label.toLowerCase().replace(' ', '_') )

</script>

<template>
    <div>
        <label v-if="props.label" :for="snakeCaseLabel"
               class="block text-sm mb-2 font-medium text-slate-700 dark:text-slate-300">
            {{ props.label }}
        </label>

        <div class="relative rounded-md">
            <div class="pointer-events-none w-8 absolute inset-y-0 left-0">
                <span class="flex items-center justify-center h-full w-full text-sm text-slate-400">
                    <font-awesome-icon :icon="props.icon"/>
                </span>
            </div>
            <input
                v-model="model"
                :id="snakeCaseLabel"
                :type="props.type"
                :placeholder="props.placeholder"
                :autocomplete="props.autocomplete"
                :disabled="props.disabled"
                class="w-full rounded-md border border-slate-300 bg-white pl-8 pr-2 py-2 text-slate-800
                   focus:outline-none focus:ring-2 focus:ring-slate-500 dark:bg-slate-900
                   dark:text-slate-100 dark:border-slate-700 disabled:bg-slate-600"
            />
        </div>
        <div v-if="error" class="text-xs text-red-500 pl-2 mt-1">{{error}}</div>
    </div>
</template>
