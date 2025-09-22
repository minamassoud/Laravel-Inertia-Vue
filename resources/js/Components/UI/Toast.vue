<script setup>

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";

const page = usePage()
const toasts = ref([])

const addToast = (timestamp, status) => {
    toasts.value.push({timestamp, status})

    setTimeout(() => {
        removeToast(timestamp)
    }, 3000)
}

const removeToast = (timestamp) => {
    toasts.value = toasts.value.filter(t => t.timestamp !== timestamp)
}

watch(() => page.props.flash.timestamp, (newTimeStamp) => {
    const statusMessage = page.props.flash.status

    if (newTimeStamp && statusMessage) {
        addToast(newTimeStamp, statusMessage)
    }

})


</script>

<template>
    <div class="fixed bottom-0 right-4 mb-4 space-y-4">

        <TransitionGroup
            enter-active-class="transition-all ease-out duration-400"
            enter-from-class="translate-y-full opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition-all ease-in duration-400"
            leave-from-class="translate-x-0 opacity-100"
            leave-to-class="translate-x-full opacity-0">

            <div v-for="toast in toasts" :key="toast.timestamp"
                 class="bg-yellow-500/40 max-w-md rounded shadow-lg px-4 py-2">

                <p class="inline-flex gap-4">
                    <span><FontAwesomeIcon icon="exclamation-triangle"/></span>
                    <span>{{ toast.status }}</span>
                </p>

            </div>

        </TransitionGroup>

    </div>
</template>
