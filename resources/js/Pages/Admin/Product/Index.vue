<template>
    <div>
        <div class="mb-4">
            <Link :href="route('admin.products.create')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Добавить</Link>
        </div>
        <div>
            <table class="border-collapse border border-gray-200 table-auto w-full text-sm">
                <thead class="bg-gray-100 dark:bg-slate-800">
                <tr>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Заголовок</th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Цена</th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Склад</th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Действия</th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Продукты</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                <template v-for="product in productsData">
                    <ProductItem @product_deleted="updateProductsData" :product="product"></ProductItem>
                    <template v-if="product.children" v-for="productChild in product.children">
                        <ProductItem @product_deleted="updateProductsData" :product="productChild"></ProductItem>
                    </template>
                </template>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import ProductItem from "@/Components/Admin/Product/ProductItem.vue";
export default {
    name: "Index",

    props: {
        products: Array
    },

    data() {
        return {
            productsData: this.products
        }
    },

    layout: AdminLayout,

    components: {
        Link,
        ProductItem
    },

    methods: {
        updateProductsData(product) {
            if (product.parent_id) {
                this.productsData.forEach(productData => {
                    if (productData.id === product.parent_id) {
                        productData.children = productData.children.filter(child => child.id !== product.id)
                    }
                })
                return
            }
            this.productsData = this.productsData.filter( productData => productData.id !== product.id);
        },
    }

}
</script>

<style scoped>

</style>
