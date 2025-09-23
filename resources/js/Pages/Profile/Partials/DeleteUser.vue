<script lang="ts" setup>

import Title from "../../../Components/UI/Title.vue";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/UI/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryBtn from "../../../Components/UI/PrimaryBtn.vue";
import {route} from "ziggy-js";
import {ref} from "vue";

const showConfirmPassword = ref(false)

const form = useForm({
    current_password: ""
})

const submit = () => {
    form.delete(route('profile.delete'), {
        preserveScroll: true,
        onError: () => {
            form.reset()
        }
    })
}

</script>

<template>
    <Container>
        <Title>Delete Profile</Title>
        <p class="mb-6">this action is permanent</p>

        <div>
            <button v-if="!showConfirmPassword"
                    class="bg-red-600 rounded shadow-lg px-4 py-2 hover:bg-red-500 active:bg-red-400"
                    @click="showConfirmPassword = true">Delete User
            </button>
        </div>
        <form v-if="showConfirmPassword"
              class="space-y-4 flex flex-row gap-3" @submit.prevent="submit">

            <InputField v-model="form.current_password" :error="form.errors.current_password" icon="key" label="Current Password"
                        type="password"/>

            <div class="inline-flex items-baseline gap-3">
                <primary-btn class="!mt-3 !w-32" type="submit">Confirm</primary-btn>
                <p class="hover:underline hover:underline-offset-2 cursor-pointer" @click="showConfirmPassword = false">
                    Cancel</p>
            </div>

        </form>
    </Container>

</template>
