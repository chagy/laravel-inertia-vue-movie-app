<template>
  <AdminLayout title="Dashboard">
    <template #header>
      Movie Attach
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto">
        <section class="container mx-auto p-6 font-mono">
          <div class="w-full flex mb-4 p-2">
            <Link
              :href="route('admin.movies.index')"
              class="
                bg-green-500
                hover:bg-green-700
                text-white
                px-4
                py-2
                rounded-lg
              "
            >
              Movie Index
            </Link>
          </div>

          <div
            class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
          >
            Trailer Form
          </div>
          <div
            class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
          >
            Trailer Form
          </div>
          <div
            class="w-full mb-8 sm:max-w-md p-6 overflow-hidden bg-white rounded-lg shadow-lg"
          >
            Trailer Form
          </div>
        </section>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import { Link,useForm } from "@inertiajs/inertia-vue3";
import Pagination from "../../Components/Pagination.vue";
import { ref, watch, defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";

const props = defineProps({
  movie: Object,
});

const form = useForm({
    title: props.movie.title,
    poster_path: props.movie.poster_path,
    video_format: props.movie.video_format,
    runtime: props.movie.runtime,
    rating: props.movie.rating,
    backdrop_path: props.movie.backdrop_path,
    lang: props.movie.lang,
    overview: props.movie.overview,
    is_public: props.movie.is_public ? true : false,

})

function submitMovie(){
    form.put(`/admin/movies/${props.movie.id}`)
}
</script>

<style>
</style>