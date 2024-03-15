<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import VueHoneypot from 'vue-honeypot'
import {ref} from "vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import PlatformDetector from "@/Components/Index/PlatformDetector.vue";

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

    <PublicLayout title="Welcome">

      <div class="max-w-7xl mx-auto mt-8 p-6 lg:p-8">
        <div class="text-gray-800 dark:text-gray-200 text-center flex flex-col justify-center items-center">
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

            <PlatformDetector :url="form.link" class="mt-4 mb-8" />

            <vue-honeypot ref="honeypot" />

            <button class="bg-green-700 text-gray-200 mx-auto p-4 rounded" type="submit">Get your link!</button>
          </form>
        </div>
      </div>
    </PublicLayout>
</template>
