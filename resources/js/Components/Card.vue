<script setup>

import {router} from "@inertiajs/vue3";


const props = defineProps({
    listing: Object,
    filters: Object,
})

const filterUser = () => {
    router.get(route('home'),
        {
            user: props.listing.user.id,
            search: props.filters.search,
            tag: props.filters.tag
        }, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
}

const filterTags = (tag) => {
    router.get(route('home'),
        {
            tag: tag,
            search: props.filters.search,
            user: props.filters.user
        }, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
}

</script>

<template>
    <div class="rounded overflow-hidden shadow-lg bg-gray-200 dark:bg-slate-800">
        <div class="bg-slate-500">
            <img :src="listing.image ? `/storage/${listing.image}` : '/storage/default/listing/default_img.jpg'"
                 alt="image" class="w-full h-48 object-cover object-center">
        </div>
        <div class="p-4 flex flex-col gap-4">
            <p class="font-bold">
                {{ listing.title.substring(0, 40) }}{{ listing.title.length > 40 ? '...' : '.' }}
            </p>
            <p>
                Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by
                <button class="text-link" @click="filterUser">
                    {{ listing.user.name }}
                </button>
            </p>
            <div class="flex flex-row flex-wrap gap-3">
                <span v-for="tag in listing.tags.split(',')" :key="tag" class="pullet-btn cursor-pointer"
                      @click="filterTags(tag)">
                    {{ tag }}
                </span>
            </div>

        </div>

    </div>
</template>
