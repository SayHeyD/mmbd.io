<script setup>
//** Logos **//

// YouTube
import YouTubeDarkLogo from '../../../img/logos/youtube_dark.png'
import YouTubeLightLogo from '../../../img/logos/youtube_light.png'

// TikTok
import TikTokDarkLogo from '../../../img/logos/tiktok_dark.png'
import TikTokLightLogo from '../../../img/logos/tiktok_light.png'

const props = defineProps({
    url: String
})

</script>

<template>
  <div class="max-w-xl mx-auto flex flex-wrap">

    <div class="flex items-center justify-around px-6 py-2 rounded text-red-500 border-red-500">
      <img :src="YouTubeDarkLogo" class="hidden dark:block w-32" alt="YouTube Logo">
      <img :src="YouTubeLightLogo" class="block dark:hidden w-32" alt="YouTube Logo">
    </div>

    <div class="flex items-center justify-around px-6 py-2 rounded text-red-500 border-red-500">
      <img :src="TikTokDarkLogo" class="hidden dark:block w-32" alt="YouTube Logo">
      <img :src="TikTokLightLogo" class="block dark:hidden w-32" alt="YouTube Logo">
    </div>
  </div>
</template>