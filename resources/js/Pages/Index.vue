<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import VueHoneypot from 'vue-honeypot'
import {ref} from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});

const honeypot = ref(null)

const form = useForm({
    link: "",
})

const submitForm = () => {

    try {
        honeypot.value.validate()
        form.put(route('post.store'))
    } catch (error) {
        window.location.reload()
    }
}

</script>

<template>
    <Head title="Welcome" />

    <div class="flex flex-col justify-center items-center sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
      <div v-if="canLogin && false" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
          <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

          <template v-else>
              <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

              <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
          </template>
      </div>

      <div class="max-w-7xl mx-auto pt-32 flex-1 p-6 lg:p-8">
        <div class="dark:text-gray-200 text-center flex flex-col justify-center items-center">
          <h1 class="text-2xl font-bold mb-4">mmbd.io</h1>
          <p class="text-lg mb-6">Does your grandma get confused by cookie banners too? 👵🏼🍪</p>

          <p class="text-sm dark:text-gray-400">Paste the link to the post you'd like to share and receive a cookie-banner free version!</p>
          <form @submit.prevent="submitForm"
                class="mt-8 w-full flex flex-col">
            <TextInput class="w-full mb-4 border"
                       :error="form.errors['link'] != null && !form.isDirty"
                       autocomplete="off"
                       placeholder="https://tiktok.com/..." v-model="form.link" />
            <div v-if="form.errors['link'] != null"
                 class="text-red-700 text-start mx-auto mb-4">
              <ul class="list-disc">
                <li v-text="form.errors['link']"></li>
              </ul>
            </div>

            <vue-honeypot ref="honeypot" />

            <button class="bg-green-700 mx-auto p-4 rounded" type="submit">Get your link!</button>
          </form>
        </div>
      </div>
      <p class="p-4">
        <Link :href="route('how-it-works.show')" class="self-end font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">How it works</Link>
      </p>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
