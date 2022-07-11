<template>
    <div>
        <img class="image" :src="storage(path)" alt="Image">
    </div>
</template>

<script>
import router from "../../../router";

export default {
    name: "ImageSection",
    props: {
        path: null
    },
    methods: {
        storage(path) {
            return '/storage/' + path
        }
    }
}
</script>

<style scoped>
.image {
    max-width: 100%;
    image-resolution: normal;
}
</style>
