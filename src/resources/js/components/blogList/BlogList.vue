<template>
    <div class="blogs-container">
        <filter-component
            @sort-by-newest="sortByNewest"
            @filter-by-tags="filterByTags"/>
        <div class="blogs-list">
            <blog-preview
                v-for="blog in filteredBlogs"
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
import FilterComponent from "./FilterComponent";

export default {
    name: "BlogList",
    components: {BlogPreview, FilterComponent},
    data() {
        return {
            blogs: [],
            filteredBlogs: [],
            currentTags: [],
        }
    },
    mounted() {
        axios.get('/api/blog/all')
            .then(r => {
                this.blogs = r.data
                this.filteredBlogs = this.shuffle(r.data)
            })
            .catch(e => console.log(e.response))
    },
    methods: {
        shuffle(arr) {
            return arr.sort(() => Math.round(Math.random() * 100) - 50);
        },
        sortByNewest() {
            this.filteredBlogs.sort((a, b) => a.created_at < b.created_at ? 1 : -1)
        },
        filterByTags(e) {
            this.currentTags = e
        },
        containsAll(needles, haystack) {
            for (let item of needles) {
                if (haystack.includes(item)) {
                    return true
                }
            }
            return false
        }
    },
    watch: {
        currentTags: function (arr) {
            if (arr.length < 1) {
                this.filteredBlogs = this.blogs
            } else {
                this.filteredBlogs = this.blogs
                let currentTags = arr.map(tag => tag.id)

                this.filteredBlogs = this.filteredBlogs.filter(blog => {
                        const blogTags = blog.tags.map(tag => {
                            return tag.id
                        })
                        if (this.containsAll(currentTags, blogTags)) {
                            return blog
                        } else {
                            return false
                        }
                    }
                )
            }

        }
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
