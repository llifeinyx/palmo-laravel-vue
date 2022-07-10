<template>
    <div class="blogs-container">
        <div class="blogs-list">
            <blog-preview
                v-for="blog in blogs"
                :id ="blog.id"
                :key="blog.id"
                :title="blog.title"
                :author="blog.user.name"
                :tags="blog.tags"
                :image="blog.image_sections[0].path"
                :created_at="blog.created_at.split('T')[0]"/>
        </div>
    </div>
</template>

<script>
import BlogPreview from "./blog/BlogPreview";
export default {
    name: "BlogList",
    components: {BlogPreview},
    data() {
        return {
            blogs: []
        }
    },
    mounted() {
        axios.get('/api/blog/all')
            .then(r => {
                //console.log(r.data)
                this.blogs = r.data
            })
            .catch(e => console.log(e.response))
    }
}
</script>

<style scoped>
.blogs-container {
    margin: 50px;
}
.blogs-list {
    margin: 0 auto;
    max-width: 1280px;
    gap: 15px;
    display: flex;
    flex-flow: wrap;
}
</style>
