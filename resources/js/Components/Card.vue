<script setup>

const props = defineProps({
    listing: Object
})

</script>

<template>
    <div class="rounded shadow-lg bg-gray-200 dark:bg-slate-800">
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
                <button class="text-link">
                    {{ listing.user.name }}
                </button>
            </p>
            <div class="flex flex-row flex-wrap gap-3">
                <span v-for="tag in listing.tags.split(',')" :key="tag" class="pullet-btn cursor-pointer">
                    {{ tag }}
                </span>
            </div>

        </div>

    </div>
</template>
