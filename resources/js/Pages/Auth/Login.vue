<script setup>

import Container from "../../Components/Container.vue";
import Title from "../../Components/UI/Title.vue";
import TextLink from "../../Components/UI/TextLink.vue";
import InputField from "../../Components/UI/InputField.vue";
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Checkbox from "../../Components/UI/Checkbox.vue";

const form = useForm({
    email: "",
    password: "",
    remember_me: "",
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset()
    })
}

</script>

<template>
    <Head title="- Login"/>
    <Container class="md:w-1/2">
        <div class="text-center mb-8">
            <Title>Login</Title>
            <p>
                Sign up for a new account ?
                <TextLink label="Register" route-name="register"/>
            </p>
        </div>

        <form class="space-y-5" @submit.prevent="submit">

            <InputField v-model="form.email" :error="form.errors.email" autocomplete="email" icon="envelope" label="Email"
                        type="email"/>
            <InputField v-model="form.password" :error="form.errors.password" autocomplete="current-password" icon="key"
                        label="Password" type="password"/>

            <div class="flex items-center justify-between !mb-4">
                <Checkbox v-model="form.remember_me" name="remember_me">Remember Me</Checkbox>
                <TextLink label="Forgot my Password" route-name="forgotPassword"/>
            </div>

            <PrimaryBtn :disabled="form.processing" type="submit">Login</PrimaryBtn>
        </form>

    </Container>
</template>
