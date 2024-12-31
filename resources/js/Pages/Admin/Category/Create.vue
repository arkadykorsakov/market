<template>
    <div>
        <div class="mb-4">
            <Link :href="route('admin.categories.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
        </div>
        <div>
            <div class="mb-4">
                <input type="text" v-model="category.title" class="border border-gray-200 p-2 w-1/4" placeholder="Заголовок">
            </div>
            <div class="mb-4">
                <select v-model="category.parent_id" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите категорию</option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
            </div>
            <div class="mb-4">
                <a href="#" @click.prevent="storeCategory"  class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Создать</a>
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
        categories: Array
    },

    components: {
        Link
    },

    data() {
        return {
            category: {
                parent_id: null
            }
        }
    },

    methods: {
        storeCategory() {
            axios.post(route('admin.categories.store'), this.category)
            .then(res => {
                this.categories.push(res.data)
                this.category = {
                    parent_id: null
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
