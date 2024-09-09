<template>
    <div v-if="links.length > 0" class="flex items-center justify-between">
        <!-- Previous Page Link -->
        <button
            v-if="links.prev"
            @click="changePage(links.prev.url)"
            :class="['px-4 py-2 text-sm font-medium border rounded-lg', {
                'text-white bg-blue-500': links.prev.active,
                'text-blue-500 hover:bg-blue-100': !links.prev.active
            }]"
        >
            &laquo; Previous
        </button>

        <!-- Page Links -->
        <div class="flex flex-wrap items-center">
            <template v-for="(link, index) in links" :key="index">
                <button
                    v-if="link.url"
                    :key="'link-' + index"
                    @click="changePage(link.url)"
                    :class="['px-4 py-2 text-sm font-medium border rounded-lg', {
                        'text-white bg-blue-500': link.active,
                        'text-blue-500 hover:bg-blue-100': !link.active
                    }]"
                >
                    {{ cleanLabel(link.label) }}
                </button>
                <span
                    v-else
                    :key="'span-' + index"
                    class="px-4 py-2 text-sm text-gray-400"
                >
                    {{ cleanLabel(link.label) }}
                </span>
            </template>
        </div>

        <!-- Next Page Link -->
        <button
            v-if="links.next"
            @click="changePage(links.next.url)"
            :class="['px-4 py-2 text-sm font-medium border rounded-lg', {
                'text-white bg-blue-500': links.next.active,
                'text-blue-500 hover:bg-blue-100': !links.next.active
            }]"
        >
            Next &raquo;
        </button>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

// Props
const props = defineProps({
    links: Array
});

// Emits
const emit = defineEmits(['page-changed']);

// Method to handle page change
const changePage = (url) => {
    emit('page-changed', url);
};

// Method to clean unwanted characters from label
const cleanLabel = (label) => {
    return label
        .replace(/&raquo;/g, '') // Remove &raquo;
        .replace(/&laquo;/g, '') // Remove &laquo;
        .trim(); // Trim any extra whitespace
};
</script>
