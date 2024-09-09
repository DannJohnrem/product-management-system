<template>
    <Head title="Product List" />

    <AuthenticatedLayout>
        <template #header>
            Product List
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <!-- Search and Filter -->
            <div class="mb-4">
                <input v-model="search" @input="fetchProducts" placeholder="Search..." class="p-2 border">
                <select v-model="category" @change="fetchProducts" class="p-2 ml-2 border">
                    <option value="">All product</option>
                    <option value="tablet">tablet</option>
                    <option value="phone">phone</option>
                    <option value="laptop">laptop</option>
                </select>
            </div>
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    <tr v-for="product in products.data" :key="product.id">
                        <td class="px-6 py-3 text-sm">{{ product.name }}</td>
                        <td class="px-6 py-3 text-sm">{{ product.description }}</td>
                        <td class="px-6 py-3 text-sm">{{ product.price }}</td>
                        <td class="px-6 py-3 text-sm">{{ product.category }}</td>
                        <td class="px-6 py-3 text-sm">
                            <button @click="deleteProduct(product.id)"
                                class="px-4 py-2 text-white bg-red-500">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 sm:grid-cols-9">
                <Pagination
                    :links="products.links"
                    :current-page="products.current_page"
                    @page-changed="fetchPageData"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Reactive variables
const products = ref({ data: [], links: [], current_page: 1 });
const search = ref('');
const category = ref('');
const itemsPerPage = ref(10);

// Fetch products from API
const fetchProducts = async () => {
    try {
        const response = await axios.get('/api/v1/products', {
            params: {
                search: search.value,
                category: category.value,
                per_page: itemsPerPage.value
            }
        });
        products.value = response.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

// Fetch products for a specific page
const fetchPageData = async (url) => {
    try {
        const response = await axios.get(url, {
            params: {
                search: search.value,
                category: category.value,
                per_page: itemsPerPage.value
            }
        });
        products.value = response.data;
    } catch (error) {
        console.error('Error fetching page data:', error);
    }
};

// Delete product
const deleteProduct = async (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        try {
            await axios.delete(`/api/v1/products/${id}`);
            fetchProducts();
        } catch (error) {
            console.error('Error deleting product:', error);
        }
    }
};

// Fetch products when the component is mounted
onMounted(() => {
    fetchProducts();
});
</script>
