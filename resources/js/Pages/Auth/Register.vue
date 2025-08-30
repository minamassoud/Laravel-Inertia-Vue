<script setup>

import Container from "../../Components/Container.vue";
import Title from "../../Components/UI/Title.vue";
import TextLink from "../../Components/UI/TextLink.vue";
import InputField from "../../Components/UI/InputField.vue";
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm} from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset("password", "password_confirmation")
    })
}

</script>

<template>
    <Head title="- Register"/>
    <Container class="md:w-1/2">
        <div class="text-center mb-8">
            <Title>Register a new account</Title>
            <p>
                Already have an account?
                <TextLink label="Login" route-name="login"/>
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">

            <InputField label="Name" autocomplete="given-name" icon="id-badge" v-model="form.name" :error="form.errors.name"/>
            <InputField label="Email" autocomplete="email" type="email" icon="envelope" v-model="form.email" :error="form.errors.email"/>
            <InputField label="Password" autocomplete="new-password" type="password" icon="key" v-model="form.password" :error="form.errors.password"/>
            <InputField label="Confirm Password" autocomplete="new-password" type="password" icon="key" v-model="form.password_confirmation" :error="form.errors.password_confirmation"/>

            <p class="text-slate-500 dark:text-slate-400 text-sm text-center">
                By creating an account, you agree to our Terms of Service and Privacy Policy.
            </p>

            <PrimaryBtn type="submit" :disabled="form.processing">Register</PrimaryBtn>
        </form>

    </Container>
</template>
