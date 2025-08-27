<script setup>
import {computed, defineProps} from 'vue';
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    routeName: {
        type: String,
        required: true
    },
    componentName: {
        type: String,
        required: true
    }
});

const page = usePage()

const isActiveComponent = computed(() => page.component === props.componentName)
</script>

<template>
    <Link
        :href="route(props.routeName)"
        class="px-3 py-2 rounded-md hover:bg-slate-700"
        :class="{'bg-slate-700 pointer-events-none': isActiveComponent}"
    >
        <slot />
    </Link>
</template>
