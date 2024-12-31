<template>
    <div class="p-4 border border-gray-200 bg-white">
        <div class="mb-4">
            <Link :href="route('client.products.show', product.id)"><h3>{{ product.title }}</h3></Link>
        </div>
        <img class="mb-4" :src="product.preview_image_url" :alt="product.title">
        <div class="flex items-center mb-4">
            <p :class="[product.old_price ? 'text-red-700' : '', 'mr-2']">{{ product.price }}</p>
            <p v-if="product.old_price" class="line-through">{{ product.old_price }}</p>
        </div>
        <StoreOrUpdateCart :product="product"></StoreOrUpdateCart>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import StoreOrUpdateCart from "@/Components/Client/Cart/StoreOrUpdateCart.vue";

export default {
    name: "ProductItem",

    props: {
        product: Object
    },

    components: {
        Link,
        StoreOrUpdateCart,
    }
}
</script>

<style scoped>

</style>
