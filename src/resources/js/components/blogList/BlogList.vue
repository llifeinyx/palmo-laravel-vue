<template>
    <div class="blogs-container">
        <filter-component
            @sort-by-newest="sortByNewest"
            @filter-by-tags="filterByTags"
            @filter-by-name="filterByName"
            @update-current-tags="updateCurrentTags"
            @update-name="updateName"/>
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
            backupBlogs: [],
            currentTags: [],
            filterBoolean: true
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
        filterByName(e) {
            this.filteredBlogs = this.filteredBlogs.filter(blog => blog.title.includes(e))
        },
        filterByTags(e) {
            this.currentTags = e
            let currentTags = this.currentTags.map(tag => tag.id)

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
        },
        updateCurrentTags(e) {
            this.currentTags = e
            this.globalFilter(this.name, this.currentTags)
        },
        updateName(e) {
            this.name = e
            this.globalFilter(this.name, this.currentTags)
        },
        globalFilter(name, tags) {
            this.filteredBlogs = this.blogs

            if (name) {
                this.filterByName(name)
            }
            if (tags.length > 0) {
                this.filterByTags(tags)
            }
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
