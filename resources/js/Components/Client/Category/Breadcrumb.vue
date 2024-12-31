<template>
    <div class="mb-4">
        <Link :href="route('client.categories.index')">Категории</Link>
        <span> / </span>
        <template v-for="breadcrumb in breadcrumbs">
            <Link :href="route('client.categories.products.index', breadcrumb.id)">{{ breadcrumb.title }}</Link>
            <span> / </span>
        </template>
        <span>{{ current }}</span>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "Breadcrumb",

    props: {
        breadcrumbs: Array,
        current: String
    },

    components: {
        Link
    }
}
</script>

<style scoped>

</style>
