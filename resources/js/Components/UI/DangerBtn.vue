<script setup>

const props = defineProps({
    type: {
        type: String,
        default: "button",
    }
})

</script>

<template>
    <button
        :type="props.type"
        class="w-full rounded-lg bg-red-800 text-white px-4 py-2
        hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600
        disabled:bg-red-300 disabled:cursor-wait"
    >
        <slot/>
    </button>
</template>
