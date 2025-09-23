<script lang="ts" setup>

import UpdateInformation from "./Partials/UpdateInformation.vue";
import UpdatePassword from "./Partials/UpdatePassword.vue";
import DeleteUser from "./Partials/DeleteUser.vue";


const props = defineProps({
    user: Object,
})

</script>

<template>
    <div class="space-y-6">
        <UpdateInformation :user="props.user"/>
        <UpdatePassword/>
        <DeleteUser/>
    </div>
</template>
