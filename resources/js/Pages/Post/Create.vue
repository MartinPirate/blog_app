<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Post
            </h2>
        </template>
        <!--        <form @submit.prevent="store">
                    <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                        <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2"
                                    label="Name"/>
                        <text-input v-model="form.description" :error="form.errors.description"
                                    class="pb-8 pr-6 w-full lg:w-1/2" lable="Description"/>
                        <text-input v-model="form.publishedAt" :error="form.errors.publishedAt"
                                    class="pb-8 pr-6 w-full lg:w-1/2"
                                    type="date" label="PublishedDate"/>
                    </div>
                    <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Post
                        </loading-button>
                    </div>
                </form>-->

        <div class="flex justify-center">
            <div class="w-full max-w-xs">
                <form class="bg-white shadow-md rounded px-10 pt-6 pb-8 mb-4 mt-5" @submit.prevent="store">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Title
                        </label>
                        <input v-model="form.title"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="tile" type="text" placeholder="Post Title">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description
                        </label>
                        <textarea v-model="form.description"
                                  class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text"/>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="publishedAt">
                            Published Date
                        </label>
                        <input v-model="form.publishedAt"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="publishedAt" type="datetime-local" placeholder="Published Date">
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Create Post
                        </button>

                    </div>
                </form>
            </div>

        </div>


    </AppLayout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import TextInput from "../../Components/TextInput.vue";
import LoadingButton from "../../Components/LoadingButton.vue";
import {defineComponent} from "vue";

export default defineComponent({
    components: {LoadingButton, TextInput, AppLayout},

    data() {
        return {
            form: this.$inertia.form({
                title: '',
                description: '',
                publishedAt: '',

            }),
        }
    }
    ,
    methods: {
        store() {
            this.form.post('/posts')
        },
    }
})


</script>
