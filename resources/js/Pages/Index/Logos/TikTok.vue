<script setup>
import TikTokDarkLogo from "../../../../img/logos/tiktok_dark.png";
import TikTokLightLogo from "../../../../img/logos/tiktok_light.png";
</script>

<template>
  <div class="flex justify-center items-center px-6 py-2">
    <img :src="TikTokDarkLogo" class="hidden dark:block w-32" alt="TikTok Logo">
    <img :src="TikTokLightLogo" class="block dark:hidden w-32" alt="TikTok Logo">
  </div>
</template>