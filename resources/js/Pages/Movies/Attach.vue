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
                  Update
                </JetButton>
              </div>
            </form>
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
  trailers: Array
});

const form = useForm({
    name: '',
    embed_html: ''
})

function submitTrailer(){
    form.post(`/admin/movies/${props.movie.id}/add-trailer`,{
        onSuccess: () => form.reset()
    })
}
</script>

<style>
</style>