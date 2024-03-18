<script setup>
import YouTubeDarkLogo from "../../../../img/logos/youtube_dark.png";
import YouTubeLightLogo from "../../../../img/logos/youtube_light.png";
</script>

<template>
  <div class="flex justify-center items-center px-6 py-2">
    <img :src="YouTubeDarkLogo" class="hidden dark:block w-32" alt="YouTube Logo">
    <img :src="YouTubeLightLogo" class="block dark:hidden w-32" alt="YouTube Logo">
  </div>
</template>