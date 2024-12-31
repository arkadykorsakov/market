<template>
    <aside class="w-1/4 bg-gray-900 min-h-screen">
        <nav class="p-4">
            <div>
                <div class="mb-8">
                    <div>
                        <h3 class="text-white mb-2">Категории</h3>
                    </div>
                    <div>
                        <div v-if="breadcrumbs.length > 0">
                            <Link v-for="breadcrumb in breadcrumbs" :href="route('client.categories.products.index', breadcrumb.id)"
                                  class="text-gray-200 block py-4 border-b border-gray-600 text-sm"
                            >< {{ breadcrumb.title }}</Link>
                        </div>
                        <div v-if="categoryChildren.length > 0">
                            <Link v-for="categoryChild in categoryChildren" :href="route('client.categories.products.index', categoryChild.id)"
                                  class="text-gray-200 block py-4 border-b border-gray-600  text-sm"
                            >{{ categoryChild.title }}</Link>
                        </div>
                    </div>
                </div>
                <template v-for="param in params">
                    <div v-if="param.filter_type === 3" class="mb-4 pb-4 border-b border-gray-600">
                        <div>
                            <h3 class="text-white mb-2">{{ param.title }}</h3>
                        </div>
                        <div>
                            <div v-for="value in param.param_values" class="mb-2 flex items-center">
                                <input @change="setFilter(param, value)" class="mr-2" type="checkbox" :value="value"
                                       :id="value">
                                <label v-if="param.label === 'color'" :style="`background: ${value}; width: 32px; height: 16px;`" class="block text-sm text-gray-300" :for="value"></label>
                                <label v-if="param.label !== 'color'" class="text-sm text-gray-300" :for="value">{{ value }}</label>
                            </div>
                        </div>
                    </div>
                    <div v-if="param.filter_type === 1" class="mb-4 pb-4 border-b border-gray-600">
                        <div>
                            <h3 class="text-white mb-2">{{ param.title }}</h3>
                        </div>
                        <div>
                            <div class="mb-2 flex items-center">
                                <input v-model="filters.integer.from[param.id]" type="number" placeholder="От"
                                       class="w-1/4 border border-gray-200 p-2 mr-4">
                                <input v-model="filters.integer.to[param.id]" type="number" placeholder="До"
                                       class="w-1/4 border border-gray-200 p-2">
                            </div>
                        </div>
                    </div>
                </template>
                <div>
                    <a @click.prevent="getPosts"
                       href="#"
                       class="block text-center px-3 py-2 text-gray-300 bg-indigo-800 border border-indigo-900">Фильтр</a>
                </div>
            </div>
        </nav>
    </aside>
    <article class="w-3/4 bg-gray-50 p-4">
        <Breadcrumb :breadcrumbs="breadcrumbs" :current="category.title" />
        <div class="grid grid-cols-3 gap-4">
            <ProductItem v-for="product in productsData" :product="product"></ProductItem>
        </div>
    </article>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";
import Breadcrumb from "@/Components/Client/Category/Breadcrumb.vue";
export default {
    name: "ProductIndex",
    layout: MainLayout,

    components: {
        ProductItem,
        Link,
        Breadcrumb,
    },

    props: {
        category: Object,
        products: Array,
        breadcrumbs: Array,
        params: Array,
        categoryChildren: Array,
    },


    data() {
        return {
            productsData: this.products,
            filters: {
                integer: {
                    from: {},
                    to: {},
                },
                select: {},
                checkbox: {}

            },
        }
    },


    methods: {
        setFilter(param, value) {
            if (this.filters.checkbox[param.id]) {
                this.toggleItem(this.filters.checkbox[param.id], value)
                return;
            }
            this.filters.checkbox[param.id] = []
            this.filters.checkbox[param.id].push(value)
        },

        toggleItem(arr, value) {
            let index = arr.indexOf(value)
            index === -1 ? arr.push(value) : arr.splice(index, 1)
        },

        getPosts() {
            this.clean(this.filters.integer.from)
            this.clean(this.filters.integer.to)

            axios.get(route('client.categories.products.index', this.category.id), {
                params: this.filters
            })
            .then( res => {
                this.productsData = res.data
            })
        },

        clean(obj) {
            Object.keys(obj).forEach( key => {
                if (!obj[key]) {
                    delete obj[key]
                }
            })
        }
    }


}
</script>

<style scoped>

</style>
