<script setup>

import Container from "../../Components/Container.vue";
import Title from "../../Components/UI/Title.vue";
import InputField from "../../Components/UI/InputField.vue";
import PrimaryBtn from "../../Components/UI/PrimaryBtn.vue";
import {Head, useForm} from "@inertiajs/vue3";


const form = useForm({
    password: "",
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset()
    })
}

</script>

<template>
    <Head title="Confirm Password"/>

    <Container class="md:w-1/2">
        <div class="text-center mb-8">
            <Title>Confirm Password</Title>
        </div>

        <form class="space-y-5" @submit.prevent="submit">

            <InputField v-model="form.password" :error="form.errors.password" icon="key"
                        label="Password" type="password"/>

            <PrimaryBtn :disabled="form.processing" type="submit">Confirm</PrimaryBtn>
        </form>

    </Container>
</template>
