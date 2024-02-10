<script setup>
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    post: Object
})

const isShortsVideo = () => {
    return props.post.original_url.includes('/shorts/')
}

const generateEmbedUrl = (videoId, timestamp = null) => {
    let embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}`

    if (timestamp != null) {
        embedUrl += `?start=${timestamp}`
    }

    return embedUrl
}

const getEmbedUrl = () => {

    if (isShortsVideo()) {
        const urlParts = props.post.original_url.split('/')
        const videoId = urlParts[urlParts.length - 1]
        return generateEmbedUrl(videoId)
    }

    const searchString = props.post.original_url.slice(props.post.original_url.indexOf('?') + 1)
    const urlParams = new URLSearchParams(searchString)
    const videoId = urlParams.get('v')

    const timestamp = urlParams.get('t')

    return generateEmbedUrl(videoId, timestamp)
}

const getThumbnailUrl = () => {
    // Extract video id from url
    let videoId = props.post.original_url.split('v=')[1];

    // Generate thumbnail url
    return "https://img.youtube.com/vi/" + videoId + "/0.jpg";
}
</script>

<template>
  <Head>
    <meta property="og:image" :content="getThumbnailUrl()" />
  </Head>
  <div v-if="isShortsVideo()">
    <iframe width="315" height="560"
            :src="getEmbedUrl()" title="YouTube video player"
            allowfullscreen="allowfullscreen"></iframe>
  </div>
  <div v-else class="iframe-container">
    <iframe sandbox="allow-scripts allow-same-origin"
            allowfullscreen="allowfullscreen"
            class="responsive-iframe" :src="getEmbedUrl()" />
  </div>
</template>

<style scoped>
.iframe-container {
    position: relative;
    overflow: hidden;
    width: 100%;
    padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
}

.responsive-iframe {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
}
</style>