<script setup>
const props = defineProps({
    post: Object
})

const getEmbedUrl = () => {
    const searchString = props.post.original_url.slice(props.post.original_url.indexOf('?') + 1)
    const urlParams = new URLSearchParams(searchString)
    const videoId = urlParams.get('v')

    const timestamp = urlParams.get('t')

    let embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}`

    if (timestamp != null) {
        embedUrl += `?start=${timestamp}`
    }

    return embedUrl
}
</script>

<template>
  <div class="iframe-container">
    <iframe sandbox="allow-scripts allow-same-origin" allowfullscreen="allowfullscreen" class="responsive-iframe" :src="getEmbedUrl()" />
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