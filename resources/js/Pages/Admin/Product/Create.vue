<template>
    <div>
        <div class="mb-4">
            <Link :href="route('admin.products.index')"
                  class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад
            </Link>
        </div>
        <div>
            <div class="mb-4">
                <input type="text" v-model="entries.product.title" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Заголовок">
                <div v-if="errors['product.title']" class="text-red-600">
                    <p v-for="error in errors['product.title']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" v-model="entries.product.article" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Артикул">
                <div v-if="errors['product.article']" class="text-red-600">
                    <p v-for="error in errors['product.article']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <textarea type="text" v-model="entries.product.description" class="border border-gray-200 p-2 w-1/4"
                          placeholder="Описание"></textarea>
                <div v-if="errors['product.description']" class="text-red-600">
                    <p v-for="error in errors['product.description']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <textarea type="text" v-model="entries.product.content" class="border border-gray-200 p-2 w-1/4"
                          placeholder="Контент"></textarea>
                <div v-if="errors['product.content']" class="text-red-600">
                    <p v-for="error in errors['product.content']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.price" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Цена">
                <div v-if="errors['product.price']" class="text-red-600">
                    <p v-for="error in errors['product.price']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.old_price" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Старая цена">
                <div v-if="errors['product.old_price']" class="text-red-600">
                    <p v-for="error in errors['product.old_price']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.qty" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Количество на складе">
                <div v-if="errors['product.qty']" class="text-red-600">
                    <p v-for="error in errors['product.qty']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <select v-model="entries.product.category_id" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите категорию</option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
                <div v-if="errors['product.category_id']" class="text-red-600">
                    <p v-for="error in errors['product.category_id']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <select v-model="entries.product.product_group_id" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите группу продуктов</option>
                    <option v-for="productGroup in productGroups" :value="productGroup.id">{{
                            productGroup.title
                        }}
                    </option>
                </select>
                <div v-if="errors['product.product_group_id']" class="text-red-600">
                    <p v-for="error in errors['product.product_group_id']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <input ref="image_input" @change="setImages" type="file" multiple
                       class="border border-gray-200 p-2 w-1/4">
            </div>
            <div class="mb-4 flex">
                <div class="mr-2">
                    <select v-model="paramOption.paramObj" class="border border-gray-200 p-2 pr-8">
                        <option :value="{}" disabled selected>Выберите характеристику</option>
                        <option v-for="param in params" :value="param">
                            {{ param.title }}
                        </option>
                    </select>
                </div>
                <div class="mr-2">
                    <input v-model="paramOption.value" type="text" class="border border-gray-200 p-2"
                           placeholder="Значение">
                </div>

                <div>
                    <a @click.prevent="setParam" href="#"
                       class="inline-block bg-white border-gray-200 border px-3 py-2">+</a>
                </div>
            </div>
            <div class="mb-4">
                <div v-for="paramEntries in entries.params" class="flex items-center mb-2">
                    <div class="mr-2">
                        {{ paramEntries.title }} - {{ paramEntries.value }}
                    </div>
                    <div>
                        <svg @click="removeParam(paramEntries)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="cursor-pointer size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <a href="#" @click.prevent="storeProduct"
                   class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Создать</a>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Create",

    layout: AdminLayout,

    props: {
        categories: Array,
        productGroups: Array,
        params: Array,
    },

    components: {
        Link
    },

    data() {
        return {
            errors: [],
            paramOption: {
                paramObj: {}
            },
            entries: {
                product: {
                    category_id: null,
                    product_group_id: null,
                },
                images: [],
                params: [],
            },
        }
    },

    methods: {
        storeProduct() {
            axios.post(route('admin.products.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(res => {
                    this.entries = {
                        product: {
                            category_id: null,
                            product_group_id: null,
                        },
                        images: [],
                        params: [],
                    }
                    this.$refs.image_input.value = null
                })
            .catch( e => {
                this.errors = e.response.data.errors;
            })
        },
        setImages(e) {
            this.entries.images = e.target.files
        },

        setParam() {
            this.entries.params.push({
                id: this.paramOption.paramObj.id,
                title: this.paramOption.paramObj.title,
                value: this.paramOption.value,
            })
        },
        removeParam(paramEntries) {
            this.entries.params = this.entries.params.filter(param => param !== paramEntries)
        }

    }
}
</script>

<style scoped>
body {
    background: #fc64ad;
}
</style>
