<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Posts from "../Components/Posts.vue";

const props = defineProps({
    posts: Object
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Posts
            </h2>
        </template>

        <a :href="route('post.create')"
           class="bg-indigo-500 text-white rounded px-8 py-2 float-right mt-4 mr-2	"
        >
            Create Post
        </a>
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="mt-4">
                        <posts :posts="props.posts"/>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
