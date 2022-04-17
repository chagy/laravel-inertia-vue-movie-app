<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from "@/Components/Navbar";
import Footer from "@/Components/Footer";

defineProps({
    title: String,
});


</script>

<template>
    <div>
        <Head :title="title" />

        <JetBanner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Navbar />
            <!-- Page Content -->
            <main>
                <slot />
            </main>
            
        </div>
        <Footer />
    </div>
</template>
