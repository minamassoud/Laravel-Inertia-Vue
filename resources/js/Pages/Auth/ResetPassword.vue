<script lang="ts" setup>

import Container from "../../Components/Container.vue"
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import InputField from "../../Components/UI/InputField.vue";

const props = defineProps({
    token: {
        default: ""
    },
    email: {
        default: ""
    }
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    })
}

</script>

<template>
    <Head title="Password Reset"/>


    <Container class="md:w-1/2">
        <form class="space-y-4" @submit.prevent="submit">

            <InputField v-model="form.email" :disabled="true" :error="form.errors.email" autocomplete="email" icon="envelope"
                        label="Email"/>
            <InputField v-model="form.password" :error="form.errors.password" autocomplete="new-password" icon="key" label="Password"
                        type="password"/>
            <InputField v-model="form.password_confirmation" :error="form.errors.password_confirmation" autocomplete="new-password" icon="key"
                        label="Confirm Password" type="password"/>

            <PrimaryBtn :disabled="form.processing" type="submit">Reset Password</PrimaryBtn>
        </form>
    </Container>

</template>
