<script lang="ts" setup>

import Container from "../../Components/Container.vue"
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import InputField from "../../Components/UI/InputField.vue";

const form = useForm({
    email: ""
})
const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => form.reset()
    })
}

</script>

<template>
    <Head title="Forgot Password"/>

    <Container class="md:w-1/2">
        <div class="mb-4">
            <p>
                Please provide your email to send you a forgot password email
            </p>
        </div>

        <form class="space-y-4" @submit.prevent="submit">
            <InputField v-model="form.email" :error="form.errors.email" autocomplete="email" icon="envelope"
                        label="email"/>
            <PrimaryBtn :disabled="form.processing" type="submit">Send Forgot Password Email</PrimaryBtn>
        </form>
    </Container>

</template>
