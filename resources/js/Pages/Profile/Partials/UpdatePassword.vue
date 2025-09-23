<script lang="ts" setup>

import Title from "../../../Components/UI/Title.vue";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/UI/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryBtn from "../../../Components/UI/PrimaryBtn.vue";
import {route} from "ziggy-js";


const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.put(route('profile.update-password'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    })
}

</script>

<template>
    <Container>
        <Title>Update Password</Title>
        <p class="mb-6">Update your account's Password.</p>

        <form class="space-y-4" @submit.prevent="submit">

            <InputField v-model="form.current_password" :error="form.errors.current_password" icon="key" label="Current Password"
                        type="password"/>
            <InputField v-model="form.password" :error="form.errors.password" autocomplete="new-password" icon="key"
                        label="New Password" type="password"/>
            <InputField v-model="form.password_confirmation" autocomplete="new-password" icon="key" label="Confirm Password"
                        type="password"/>


            <primary-btn class="!mt-8 !w-32" type="submit">Save</primary-btn>
        </form>
    </Container>

</template>
