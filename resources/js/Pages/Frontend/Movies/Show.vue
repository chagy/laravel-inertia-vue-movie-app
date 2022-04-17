<template>
    <FrontLayout>
        <main v-if="movie" class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ movie.title }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ movie.release_date }}</span>
                                    <span class="ml-2 space-x-1">
                                            <Link v-for="genre in genres" :key="genre.id" class="font-bold hover:text-blue-500"
                                                :href="`/genres/${genre.slug}`">
                                                {{ genre.title }},
                                            </Link>
                                    </span>
                                    <span class="flex space-x-2">
                                        {{ movie.runtime }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex space-x-4">
                                    Trailer
                                </div>
                            </div>
                            <div class="p-8 text-white">
                                <p>{{ movie.overview }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-white font-bold text-xl">Movie Casts</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="cast in casts" :key="cast.id">
                                <template #image>
                                    <Link :href="`/casts/${cast.slug}`">
                                        <img class=""
                                            :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                                    </Link>
                                </template>
                                <Link :href="`/casts/${cast.slug}`">
                                    <span class="text-white">{{ cast.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-white font-bold text-xl">Latest movies</h1>
                        <div class="grid grid-cols-3 gap-2" v-if="latests">
                            <Link 
                                v-for="lm in latests" 
                                :key="lm.id" 
                                :href="`/movies/${lm.slug}`">
                                <img class="w-full h-full rounded-lg"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${lm.poster_path}`">
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
            <section v-if="movie.tags" class="max-w-6xl mx-auto bg-gradient-to-r from-indigo-700 to-transparent mt-6 p-2">
                <span 
                    v-for="tag in movie.tags" :key="tag.id"
                    class="font-bold text-white hover:text-indigo-200 cursor-pointer">#{{ tag.tag_name }}</span>
            </section>
        </main>
    </FrontLayout>
</template>

<script setup>
import FrontLayout from "@/Layouts/FrontLayout";
import MovieCard from "@/Components/MovieCard";
import { Link,Head } from "@inertiajs/inertia-vue3";

defineProps({
    movie: Object,
    latests: Array,
    casts: Array,
    tags: Array,
    genres: Array,
})
</script>

<style>

</style>