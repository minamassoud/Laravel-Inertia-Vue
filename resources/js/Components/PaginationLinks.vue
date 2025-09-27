<script setup>

import {router} from "@inertiajs/vue3";

defineProps({
    links: Object,
    from: Number,
    to: Number,
    total: Number,
})

const changePreviousNextLabels = (label) => {
    if (label.includes("Previous")) {
        return "<<"
    } else if (label.includes("Next")) {
        return ">>"
    } else {
        return label
    }
}

</script>

<template>

    <!--    <div class="flex flex-row divide-x-2 divide-slate-300/40 w-fit overflow-x-hidden rounded-lg">-->


    <!--        <button v-for="(p, key) in paginator" :key="key" :disabled="!p.url"-->
    <!--                @click="router.get(p.url)"-->
    <!--                :class="{'cursor-default pointer-events-none': p.active}"-->
    <!--                class="w-24 h-20 shadow-lg bg-slate-800 hover:bg-slate-900-->
    <!--                disabled:bg-slate-800/40 disabled:cursor-default">-->
    <!--            <span :class="{'font-bold text-lg': p.active}" v-html="p.label"></span>-->
    <!--        </button>-->

    <!--    </div>-->

    <div class="flex flex-row items-center justify-between">
        <div class="flex items-center rounded-md overflow-hidden shadow-lg">

            <div v-for="(link, i) in links" :key="i">
                <component
                    :is="link.url ? 'Link': 'span'"
                    :class="{
                    'hover:bg-slate-300 dark:hover:bg-slate-500': link.url,
                    'text-slate-300' : !link.url,
                    'font-bold text-indigo-500 dark:text-indigo-400': link.active
                }"
                    :href="link.url"
                    class="border-x border-slate-50 w-12 h-12 grid place-items-center
                bg-white dark:bg-slate-900 dark:border-slate-800"
                    v-html="changePreviousNextLabels(link.label)"
                />
            </div>

        </div>

        <p class="text-slate-600 dark:text-slate-400 text-sm">
            Showing {{ from }} to {{ to }} of {{ total }} results
        </p>
    </div>


</template>
