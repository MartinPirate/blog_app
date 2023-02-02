<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import Posts from "../Components/Posts.vue";
import mapValues from "lodash/mapValues";
import PostsNotFound from "../Components/PostsNotFound.vue";


export default {
    components: {
        PostsNotFound,
        Posts,
        AppLayout,
    },
    props: {
        posts: Object,
        filters: Object

    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get('/dashboard', pickBy(this.form), {preserveState: true})
            }, 150),
        },
    },
    data() {
        return {
            form: {
                sortBy: "publication_date",
                direction: this.filters.direction,
            },
        }
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
}


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Posts
            </h2>


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

        </template>

        <a :href="route('post.create')"
           class="bg-indigo-500 text-white rounded px-8 py-2 float-right mt-4 mr-2	"
        >
            Create Post
        </a>
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="mt-4" v-if="posts.data.length !==0">
                        <posts :posts="posts"/>
                    </div>
                    <div v-else>
                        <PostsNotFound/>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
