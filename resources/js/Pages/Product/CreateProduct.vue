<template>

    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            Create Product
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-xl font-semibold">Create Product</h2>
                <form @submit.prevent="submitForm">
                    <!-- Step 1: Basic Information -->
                    <div v-if="step === 1">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>

                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input v-model="form.price" type="number" id="price"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>

                        <label for="category" class="block mt-4 text-sm font-medium text-gray-700">Category</label>
                        <select v-model="form.category" id="category"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Category</option>
                            <option v-for="category in categoryLists" :key="category.id" :value="category.id">{{
                                category.type
                                }}</option>
                        </select>

                        <label for="description"
                            class="block mt-4 text-sm font-medium text-gray-700">Description</label>
                        <textarea v-model="form.description" id="description" rows="4"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>

                        <button @click="nextStep" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Next</button>
                    </div>

                    <!-- Step 2: Image Upload -->
                    <div v-if="step === 2">
                        <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                        <input type="file" id="images" @change="handleFileChange" multiple
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <div class="mt-2">
                            <p v-for="(file, index) in form.images" :key="index">{{ file.name }}</p>
                        </div>

                        <button @click="prevStep" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded">Back</button>
                        <button @click="nextStep" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Next</button>
                    </div>

                    <!-- Step 3: Date and Time -->
                    <div v-if="step === 3">
                        <label for="date" class="block text-sm font-medium text-gray-700">Date and Time</label>
                        <input v-model="form.date" type="datetime-local" id="date"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>

                        <button @click="prevStep" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded">Back</button>
                        <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router} from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

// Define reactive form state
const form = ref({
    name: '',
    category: '',
    description: '',
    price: '',
    date: '',
    images: []
});

// Define categories
const categoryLists = [
    { id: 'phone', type: 'Phone' },
    { id: 'tablet', type: 'Tablet' },
    { id: 'laptop', type: 'Laptop' }
];

const step = ref(1); // Track the current step

// Handle file input change
const handleFileChange = (event) => {
    form.value.images = Array.from(event.target.files);
};

// Proceed to next step
const nextStep = () => {
    if (step.value < 3) {
        step.value += 1;
    }
};

// Go back to previous step
const prevStep = () => {
    if (step.value > 1) {
        step.value -= 1;
    }
};

// Submit form
const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('category', form.value.category);
        formData.append('description', form.value.description);
        formData.append('price', form.value.price);
        formData.append('date', form.value.date);

        form.value.images.forEach((image) => {
            formData.append('images[]', image);
        });

        const response = await axios.post('/api/v1/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log(response.data);
        router.get(route('product.index'));

        // Handle success
    } catch (error) {
        if (error.response && error.response.status === 422) {
            console.error('Validation errors:', error.response.data.errors);
        } else {
            console.error('Error submitting form:', error);
        }
    }
};

</script>
