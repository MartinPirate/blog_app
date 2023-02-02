<script setup>
import {Head, Link} from '@inertiajs/vue3';
import Posts from "../Components/Posts.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    posts: Object
});

</script>

<template>
    <Head><title>Welcome</title></Head>

    <!--    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.user" :href="route('dashboard')"
                      class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')"
                          class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register
                    </Link>
                </template>
            </div>

            <posts/>
        </div>-->

    <div class="relative bg-white">
        <div class="mx-auto max-w-7xl px-6">
            <div
                class="flex items-center justify-between border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="#">
                        <span class="sr-only">Logo</span>
                        <img class="h-8 w-auto sm:h-10"
                             src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                    </a>
                </div>
                <div class="-my-2 -mr-2 md:hidden">
                    <button type="button"
                            class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            aria-expanded="false">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                </div>
                <nav class="hidden space-x-10 md:flex">


                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">Dashboard</a>

                </nav>
                <div class="hidden items-center justify-end md:flex md:flex-1 lg:w-0">
                    <a href="#" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Sign
                        in</a>
                    <a href="#"
                       class="ml-8 inline-flex items-center justify-center whitespace-nowrap rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Sign
                        up</a>
                </div>
            </div>

            <div class="mt-4">
                <posts :posts="props.posts"/>
            </div>


        </div>

    </div>
</template>
