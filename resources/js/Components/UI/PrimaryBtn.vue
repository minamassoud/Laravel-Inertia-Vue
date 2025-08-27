<script setup>

const props = defineProps({
    type: {
        type:String,
        default: "button",
    }
})

</script>

<template>
    <button
        :type="props.type"
        class="w-full rounded-lg bg-slate-800 text-white px-4 py-2
        hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600
        disabled:bg-slate-300 disabled:cursor-wait"
    >
       <slot/>
    </button>
</template>
