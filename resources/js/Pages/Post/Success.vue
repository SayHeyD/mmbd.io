<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import Copy from "@/Components/Icons/Copy.vue";
import TextInput from "@/Components/TextInput.vue";
import copy from 'copy-to-clipboard';
import {ref} from "vue";
import {useToast} from "primevue/usetoast";
import PublicLayout from "@/Layouts/PublicLayout.vue";

const toast = useToast()

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});

const slug = usePage().props.jetstream.flash.slug
const url = ref(route('post.show', slug))

const copyUrl = () => {
    copy(url.value)
    toast.add({ severity: 'success', summary: 'URL Copied!', life: 5000 });
}

</script>

<template>
  <PublicLayout title="Success 🎉">

    <div class="sm:flex sm:justify-center sm:items-center h-full mt-8 selection:bg-red-500 selection:text-white">
      <div v-if="canLogin && false" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

        <template v-else>
          <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

          <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
        </template>
      </div>

      <div class="max-w-7xl mx-auto pt-32 p-6 lg:p-8">
        <div class="dark:text-gray-200 text-gray-800 text-center flex flex-col justify-center items-center">
          <h3 class="text-xl mb-4">Your post is ready! 🎉</h3>

          <div @click="copyUrl" class="flex mb-4 w-full items-center">
            <TextInput data-testid="copyUrlInput" class="w-full dark:text-gray-600" :value="url" disabled />
            <Copy data-testid="copyUrl" class="cursor-pointer ml-4 h-8 w-8" />
          </div>

          <Link :href="route('index')" class="p-4 rounded bg-gray-800 hover:underline dark:bg-gray-200 text-gray-200 dark:text-gray-800">Create a new post</Link>
          <Toast position="bottom-right"/>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<style>
.p-toast {
    max-width: calc(100vw - 40px);
}
</style>
