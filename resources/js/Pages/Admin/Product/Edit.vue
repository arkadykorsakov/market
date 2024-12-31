<template>
    <div>
        <div class="mb-4">
            <Link :href="route('admin.products.index')"
                  class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад
            </Link>
        </div>
        <div v-if="success" class="p-4 bg-green-100 mb-4">
            Успешно сохранено!
        </div>
        <div>
            <div class="mb-4">
                <input type="text" v-model="entries.product.title" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Заголовок">
            </div>
            <div class="mb-4">
                <input type="text" v-model="entries.product.article" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Заголовок">
            </div>
            <div class="mb-4">
                <textarea type="text" v-model="entries.product.description" class="border border-gray-200 p-2 w-1/4"
                          placeholder="Описание"></textarea>
            </div>
            <div class="mb-4">
                <textarea type="text" v-model="entries.product.content" class="border border-gray-200 p-2 w-1/4"
                          placeholder="Контент"></textarea>
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.price" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Цена">
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.old_price" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Старая цена">
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.qty" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Количество на складе">
            </div>
            <div class="mb-4">
                <select v-model="entries.product.category_id" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите категорию</option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
            </div>
            <div class="mb-4">
                <select v-model="entries.product.product_group_id" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите группу продуктов</option>
                    <option v-for="productGroup in productGroups" :value="productGroup.id">{{
                            productGroup.title
                        }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <input @change="setImages" type="file" multiple class="border border-gray-200 p-2 w-1/4">
            </div>
            <div class="mb-4">
                <div class="grid grid-cols-3">
                    <div v-for="image in product.images">
                        <img :src="image.url" :alt="product.title" class="mb-2">
                        <div class="text-center">
                            <a @click.prevent="deleteImage(image)" href="#"
                               class="inline-block px-2 py-1 text-sm bg-red-800 text-gray-200 border border-red-900">Удалить</a>
                        </div>
                    </div>
                </div>
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
                <a href="#" @click.prevent="updateProduct"
                   class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Сохранить</a>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Edit",

    layout: AdminLayout,

    props: {
        categories: Array,
        productGroups: Array,
        product: Object,
        params: Array,

    },

    components: {
        Link
    },

    data() {
        return {
            success: false,
            paramOption: {
                paramObj: {}
            },
            entries: {
                product: this.product,
                images: null,
                _method: 'patch',
                params: this.product.params,
            }
        }
    },

    methods: {
        updateProduct() {
            axios.post(route('admin.products.update', this.product.id), this.entries, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    this.product.images = res.data.images
                    this.$nextTick(() => {
                        this.success = true
                    })
                })
        },
        deleteImage(image) {
            axios.delete(route('admin.images.destroy', image.id))
                .then(res => {
                    this.product.images = this.product.images.filter(productImage => productImage.id !== image.id)
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
    },

    watch: {
        entries: {
            handler(){
                this.success = false
            },
            deep: true
        }
    }
}
</script>

<style scoped>
 body{
     background: #204dff;
 }
</style>


