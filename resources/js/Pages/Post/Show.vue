<script setup>
import {Head, Link} from '@inertiajs/vue3';
import YouTube from "@/Pages/Post/Partials/YouTube.vue";
import {onMounted, ref} from "vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";

const props = defineProps({
    post: Object,
    canLogin: Boolean,
    canRegister: Boolean
});

const currentUrl = ref("")

onMounted(() => {
    currentUrl.value = route(route().current(), props.post.slug)
})

</script>

<template>
  <PublicLayout title="Success" class="overflow-x-hidden">
    <Head>
      <meta v-if="post.name"
            property="og:title" content="mmbd.io - {{ post.name }}" />
      <meta v-else
            property="og:title" content="mmbd.io" />

      <meta v-if="currentUrl !== ''" property="og:url" :content="currentUrl">

      <meta property="og:description" content="View your favourite social media posts without any cookie banners!">
    </Head>

    <div class="w-screen sm:flex sm:justify-center sm:items-center selection:bg-red-500 selection:text-white">

      <div class="w-full mx-auto pt-32 p-6 lg:p-8">
        <div class="text-gray-800 dark:text-gray-200 text-center flex flex-col justify-center items-center">

          <YouTube class="mb-8" v-if="post.type == 'youtube'" :post="post" />

          <div class="mt-6">
            <p class="mb-6">Want to share your own post?</p>
            <Link :href="route('index')" class="p-4 rounded bg-gray-800 hover:underline dark:bg-gray-200 text-gray-200 dark:text-gray-800">Create a new post</Link>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
