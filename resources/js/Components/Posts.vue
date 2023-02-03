<script setup>
import Post from "./post.vue";
import Pagination from "./Pagination.vue";

const props = defineProps({
    posts: Object

})
console.log(props.posts)
</script>

<template>

    <div v-for="post in props.posts.data">
        <post :post="post" :show_info_button="true"></post>
    </div>

    <pagination class="mt-6" :links="props.posts.links"/>


</template>
