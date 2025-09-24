<script lang="ts" setup>

import Title from "../../../Components/UI/Title.vue";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/UI/InputField.vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import PrimaryBtn from "../../../Components/UI/PrimaryBtn.vue";
import {route} from "ziggy-js";

const props = defineProps({
    user: Object
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})

const submit = () => {
    form.patch(route('profile.update-information'))
}

const resendEmail = (e) => {
    router.post(route('verification.send'), {}, {
        onStart: () => {
            e.target.disabled = true
        },
        onFinish: () => {
            e.target.disabled = false
        }
    })
}

</script>

<template>
    <Container>
        <Title>Update Information</Title>
        <p class="mb-6">Update your account's profile information and email address.</p>

        <form class="space-y-4" @submit.prevent="submit">

            <InputField v-model="form.name" :error="form.errors.name" icon="id-badge" label="Name"/>
            <InputField v-model="form.email" :error="form.errors.email" icon="envelope" label="Email"/>

            <p v-if="!props.user.email_verified_at">
                Your email address is not verified
                <button class="text-link" @click="resendEmail">
                    Send a new Verification Link.
                </button>
            </p>

            <primary-btn class="!mt-8 !w-32" type="submit">Save</primary-btn>
        </form>
    </Container>

</template>
