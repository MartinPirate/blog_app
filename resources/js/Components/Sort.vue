<script setup>
</script>

<template>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700"></label>
        <div class="relative mt-1 rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm">sort by Published Date</span>
            </div>
            <form action="">
                <input type="text" name="sort" id="sort" class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div class="absolute inset-y-0 right-0 flex items-center">
                    <select id="sortby" name="sortby" class="h-full rounded-md border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" v-on="">
                        <option>ASC</option>
                        <option>DESC</option>
                    </select>
                </div>
            </form>

        </div>
    </div>
</template>
