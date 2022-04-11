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
            <div class="flex space-x-2">
                <div v-for="trailer in trailers" :key="trailer.id">
                    <Link 
                        class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                        :href="route('admin.trailer_urls.destroy',trailer.id)" 
                        method="delete" 
                        as="button" 
                        type="button">
                    {{ trailer.name }}
                    </Link>
                </div>
            </div>
            
            <form @submit.prevent="submitTrailer">
              <div>
                <JetLabel for="name" value="Name" />
                <JetInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="mt-1 block w-full"
                  autofocus
                  autocomplete="name"
                />
                <div class="text-sm text-red-400" v-if="form.errors.name">{{ form.errors.name }}</div>
              </div>

              <div class="mt-4">
                <JetLabel for="embed_html" value="Embed" />
                <textarea
                  id="embed_html"
                  v-model="form.embed_html"
                  class="mt-1 block w-full"
                />
                <div class="text-sm text-red-400" v-if="form.errors.embed_html">{{ form.errors.embed_html }}</div>
              </div>

              <div class="flex items-center justify-end mt-4">

                <JetButton
                  class="ml-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Add Trailer
                </JetButton>
              </div>
            </form>
          </div>
          <div
            class="w-full mb-8 sm:max-w-md p-6 bg-white rounded-lg shadow-lg"
          >
            <div>
                <div class="flex">
                    <div class="m-2 p-1 text-xs" v-for="mc in movieCasts" :key="mc.id">{{ mc.tag_name }}</div>
                </div>
                <form @submit.prevent="addCast">
                    <Multiselect 
                        v-model="castForm.casts" 
                        :options="casts" 
                        :multiple="true" 
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        placeholder="Add Cast"
                        label="name"
                        track-by="name"
                        :preselect-first="true"></Multiselect>
                    <div class="mt-2">
                        <JetButton>add cast</JetButton>
                    </div>
                </form>
            </div>
          </div>
          <div
            class="w-full mb-8 sm:max-w-md p-6 bg-white rounded-lg shadow-lg"
          >
            <div>
                <div class="flex">
                    <div class="m-2 p-1 text-xs" v-for="mt in movieTags" :key="mt.id">{{ mt.name }}</div>
                </div>
                <form @submit.prevent="addTag">
                    <Multiselect 
                        v-model="tagForm.tags" 
                        :options="tags" 
                        :multiple="true" 
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        placeholder="Add Tag"
                        label="tag_name"
                        track-by="tag_name"
                        :preselect-first="true"></Multiselect>
                    <div class="mt-2">
                        <JetButton>add tag</JetButton>
                    </div>
                </form>
            </div>
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
import Multiselect from 'vue-multiselect';

const props = defineProps({
  movie: Object,
  trailers: Array,
  casts: Array,
  tags: Array,
  movieTags: Array,
  movieCasts: Array,
});

const value = ref('');
const options = ['list','of','options'];
const form = useForm({
    name: '',
    embed_html: ''
})

const castForm = useForm({
    casts: props.movieCasts
})

const tagForm = useForm({
    tags: props.movieTags
})

function submitTrailer(){
    form.post(`/admin/movies/${props.movie.id}/add-trailer`,{
        onSuccess: () => form.reset()
    })
}

function addCast(){
    castForm.post(`/admin/movies/${props.movie.id}/add-casts`,{
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => castForm.reset()
    })
}

function addTag(){
    tagForm.post(`/admin/movies/${props.movie.id}/add-tags`,{
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => tagForm.reset()
    })
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style>
</style>