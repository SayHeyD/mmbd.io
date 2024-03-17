<script setup>
import {ref, watch} from "vue";

import YouTube from "@/Pages/Index/Logos/YouTube.vue";
import TikTok from "@/Pages/Index/Logos/TikTok.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage()

const platform = ref('')

const props = defineProps({
    url: String,
})

watch(() => props.url, async (newUrl) => {
    if (newUrl === '') {
        platform.value = ''
    }
    Object.keys(page.props.supported_platforms).forEach(key => {

        // Iterate through URLs of platforms
        page.props.supported_platforms[key].urls.forEach(url => {
            if (newUrl.includes(url)) {
                platform.value = key
            }
        })
    });
})

</script>

<template>
  <div class="max-w-xl mx-auto">
    <div v-if="platform == ''">
      <h3 class="text-lg font-bold">Supported platforms</h3>
      <div class="w-full flex flex-wrap min-h-20">

        <YouTube />

        <TikTok />

      </div>
    </div>
    <div v-else>
      <h3 class="text-lg font-bold">Detected platform</h3>
      <div class="w-full flex flex-wrap min-h-20">
        <YouTube v-if="platform == 'youtube'" />

        <TikTok v-else-if="platform == 'tiktok'" />
      </div>
    </div>
  </div>
</template>