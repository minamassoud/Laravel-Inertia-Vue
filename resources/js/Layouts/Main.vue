<script setup>
import {switchAppearanceTheme} from "../theme.js";
import NavLink from '../Components/UI/NavLink.vue';
import {Link, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import Toast from "../Components/UI/Toast.vue";


const page = usePage()
const user = computed(() => page.props.auth.user)

const showMenu = ref(false)

</script>

<template>
    <div v-show="showMenu" class="fixed inset-0 z-50 " @click="showMenu = false"></div>
    <Toast class="z-40"/>
    <header class="bg-slate-800 text-white ">

        <nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <NavLink routeName="home" component-name="Home">Home</NavLink>
            </div>

            <div class="flex items-center space-x-6">


                <div v-if="user" class="relative">


                    <div :class="{'bg-slate-700':showMenu}"
                         class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer"
                         @click="showMenu = !showMenu"
                    >
                        <p>{{ user.name }}</p>
                        <font-awesome-icon icon="angle-down"/>
                    </div>

                    <div v-show="showMenu" class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg
                                border border-slate-300 overflow-hidden w-40 "
                         @click="showMenu = false">

                        <Link :href="route('dashboard')" as="button"
                              class="text-left w-full px-6 py-3 hover:bg-slate-700"
                              method="get">Dashboard
                        </Link>

                        <Link :href="route('profile')" as="button" class="text-left w-full px-6 py-3 hover:bg-slate-700"
                              method="get">Profile
                        </Link>

                        <Link :href="route('logout')" as="button" class="text-left w-full px-6 py-3 hover:bg-slate-700"
                              method="post">Logout
                        </Link>
                    </div>
                </div>

                <div v-else class="space-x-6">
                    <NavLink component-name="Auth/Login" routeName="login">Login</NavLink>
                    <NavLink component-name="Auth/Register" routeName="register">Register</NavLink>
                </div>

                <button @click="switchAppearanceTheme" class="hover:bg-slate-700 w-8 h-8 rounded-full">
                    <font-awesome-icon icon="circle-half-stroke"/>
                </button>
            </div>

        </nav>

    </header>


    <main class="p-6 mx-auto max-w-screen-lg">
        <slot/>
    </main>
</template>
