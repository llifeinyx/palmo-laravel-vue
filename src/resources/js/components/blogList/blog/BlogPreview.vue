<template>
    <div>
        <div class="preview-card">
            <img @click="openBlog" class="preview-card__image" :src="storage(image)" alt="Image">
            <div class="preview-card__main-line">
                <div>
                    Title: {{title}}
                </div>
                <div>
                    Author: {{author}}
                </div>
            </div>
            <div class="preview-card__tag-line">
                Tags: <tag v-for="tag in tags" :key="tag.id" :name="tag.name"/>
            </div>
            <div class="preview-card__created-at">
                Created at: {{created_at}}
            </div>
        </div>
    </div>
</template>

<script>
import Tag from "../../miscellanea/Tag";
import router from "../../../router";

export default {
    name: "BlogPreview",
    components: {Tag},

    props: {
        image: null,
        title: null,
        author: null,
        tags: [],
        created_at: null,
        id: null
    },
    methods: {
        storage(path) {
            return 'storage/' + path
        },
        openBlog() {
            router.push('blog/' + this.id)
        }

    }
}
</script>

<style scoped>
.preview-card {
    color: #EBE8EF;
    font-size: 16px;
    width: 400px;
    /*height: 300px;*/
    background-color: #2d3748;
}
.preview-card__main-line {
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
}
.preview-card__image:hover {
    cursor: pointer;
}
.preview-card__image {
    image-resolution: normal;
    max-width: 100%;
    max-height: 300px;
}
.preview-card__tag-line {
    padding: 10px 20px;
    display: flex;
    flex-flow: wrap;
    gap: 10px;
}
.preview-card__created-at {
    padding: 10px 20px;
    background-color: #202c41;
}
</style>
