<script setup>
import {switchAppearanceTheme} from "../theme.js";
</script>

<template>
    <header class="bg-slate-800 text-white ">

        <nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
            <Link :href="route('home')">Home</Link>

            <button @click="switchAppearanceTheme" class="hover:bg-slate-700 hover:outline outline-1 w-6 h-6 rounded-full">
                <font-awesome-icon icon="circle-half-stroke" />
            </button>
        </nav>

    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
