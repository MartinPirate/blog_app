<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post Details
            </h2>
        </template>

        <post :post="post"></post>

    </AppLayout>
</template>
<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import Post from "../../Components/post.vue";

defineProps({
    post: Object
})
</script>
