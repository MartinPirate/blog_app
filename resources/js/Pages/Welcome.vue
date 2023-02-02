<script>
import {Head, Link} from '@inertiajs/vue3';
import Posts from "../Components/Posts.vue";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import PostsNotFound from "../Components/PostsNotFound.vue";
import mapValues from "lodash/mapValues";


export default {
    components: {
        PostsNotFound,
        Head,
        Link,
        Posts,
    },
    data() {
        return {
            form: {
                sortBy: "publication_date",
                direction: this.filters.direction ?? 'desc',
            },
        }
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        posts: Object,
        filters: Object
    },

    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get('/', pickBy(this.form), {preserveState: true})
            }, 150),
        },
    },

    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },

}


</script>

<template>
    <Head><title>Welcome</title></Head>
    <div class="relative bg-white">
        <div class="mx-auto max-w-7xl px-6">
            <div v-if="canLogin"
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


                <div class="flex items-center">
                    <label for="price" class="block text-sm font-medium text-gray-700"></label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">sort by Published Date</span>
                        </div>
                        <input type="text" name="publicationDate" id="sort" readonly
                               class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select id="direction" name="direction" v-model="form.direction"
                                    class="h-full rounded-md border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="asc">ASC</option>
                                <option value="desc">DESC</option>
                            </select>
                        </div>

                    </div>

                    <button class="ml-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500 text-sm" type="button"
                            @click="reset">Reset
                    </button>
                </div>


                <nav class="hidden space-x-10 md:flex">


                    <Link v-if="$page.props.user" :href="route('dashboard')"
                          class="ttext-base font-medium text-gray-500 hover:text-gray-900">Dashboard
                    </Link>
                </nav>

                <div class="hidden items-center justify-end md:flex md:flex-1 lg:w-0">

                    <Link :href="route('login')"
                          class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Sign In
                    </Link>

                    <Link v-if="canRegister" :href="route('register')"
                          class="ml-8 inline-flex items-center justify-center whitespace-nowrap rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                        Sign
                        up
                    </Link>

                </div>
            </div>

            <div class="mt-4" v-if="posts.data.length !==0">
                <posts :posts="posts"/>
            </div>
            <div v-else>
                <PostsNotFound/>
            </div>


        </div>

    </div>
</template>
