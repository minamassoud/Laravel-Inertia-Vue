<script lang="ts" setup>

import UpdateInformation from "./Partials/UpdateInformation.vue";


const props = defineProps({
    user: Object,
})

</script>

<template>
    <UpdateInformation :user="user"/>
</template>
