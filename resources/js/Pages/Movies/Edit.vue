<template>
  <AdminLayout title="Dashboard">
    <template #header>
      Movie Edit
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
            <form @submit.prevent="submitMovie">
                <div>
                    <JetLabel for="title" value="Title" />
                    <JetInput
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                        autocomplete="title"
                    />
                    <div class="text-sm text-red-400" v-if="form.errors.title">{{ form.errors.title }}</div>
                </div>
              <div>
                <JetLabel for="runtime" value="Runtime" />
                <JetInput
                  id="runtime"
                  v-model="form.runtime"
                  type="text"
                  class="mt-1 block w-full"
                  autofocus
                  autocomplete="runtime"
                />
                <div class="text-sm text-red-400" v-if="form.errors.runtime">{{ form.errors.runtime }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="lang" value="Language" />
                <JetInput
                  id="lang"
                  v-model="form.lang"
                  type="text"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.lang">{{ form.errors.lang }}</div>
              </div>

            <div class="mt-4">
                <JetLabel for="video_format" value="Format" />
                <JetInput
                  id="video_format"
                  v-model="form.video_format"
                  type="text"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.video_format">{{ form.errors.video_format }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="rating" value="Rating" />
                <JetInput
                  id="rating"
                  v-model="form.rating"
                  type="text"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.rating">{{ form.errors.rating }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="backdrop_path" value="Backdrop" />
                <JetInput
                  id="backdrop_path"
                  v-model="form.backdrop_path"
                  type="text"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.backdrop_path">{{ form.errors.backdrop_path }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="overview" value="Overview" />
                <JetInput
                  id="overview"
                  v-model="form.overview"
                  type="text"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.overview">{{ form.errors.overview }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="is_public" value="Public" />
                <JetCheckbox
                  id="is_public"
                  v-model="form.is_public"
                  class="mt-1"
                />
                <div class="text-sm text-red-400" v-if="form.errors.is_public">{{ form.errors.is_public }}</div>
              </div>

              <div class="flex items-center justify-end mt-4">

                <JetButton
                  class="ml-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Update
                </JetButton>
              </div>
            </form>
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