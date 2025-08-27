<script setup>
import {switchAppearanceTheme} from "../theme.js";
import NavLink from '../Components/UI/NavLink.vue';
</script>

<template>
    <header class="bg-slate-800 text-white ">

        <nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <NavLink routeName="home" component-name="Home">Home</NavLink>
            </div>

            <div class="flex items-center space-x-6">
                <NavLink routeName="register" component-name="Auth/Register">Register</NavLink>

                <button @click="switchAppearanceTheme" class="hover:bg-slate-700 w-8 h-8 rounded-full">
                    <font-awesome-icon icon="circle-half-stroke" />
                </button>
            </div>

        </nav>

    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
