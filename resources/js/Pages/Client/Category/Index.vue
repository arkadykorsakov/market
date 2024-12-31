<template>
    <article class="w-full bg-gray-50 p-4 min-h-screen">
        <div class="w-3/4 mx-auto">
            <div class="grid grid-cols-3 gap-4">
                <div v-for="category in categories">
                    <Link :href="route('client.categories.products.index', category.id)"  class="p-4 block border-gray-200 border bg-white text-center">{{ category.title }}</Link>
                </div>
            </div>
        </div>
    </article>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "ProductIndex",
    layout: MainLayout,

    components: {
        Link,
    },

    props: {
        categories: Array,
    },
}
</script>

<style scoped>

</style>
