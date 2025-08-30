<script lang="ts" setup>

import Container from "../../Components/Container.vue"
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import SessionMessage from "../../Components/UI/SessionMessage.vue";

const props = defineProps({
    status: {
        type: String,
        default: ""
    }
})

const form = useForm({})
const submit = () => {
    form.post(route('verification.send'))
}

</script>

<template>
    <Head title="Email Verification"/>
    <SessionMessage :status="props.status"/>

    <Container class="md:w-1/2">
        <div class="mb-4">
            <p>
                Thanks for signing up! Before getting started, could you verify your email address
                by clicking on the link we just emailed to you?
                <p>If you didn't receive the email, we will gladly send you another.</p>
            </p>
        </div>

        <form @submit.prevent="submit">
            <PrimaryBtn :disabled="form.processing" type="submit">Resend Verification Email</PrimaryBtn>
        </form>
    </Container>

</template>
