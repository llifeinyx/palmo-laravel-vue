<template>
    <div class="blog-container">
        Title: {{blog.title}}
        <component v-for="section in sections"
                   :is="section.type"
                   :key="section.index"
                   :path="section.path"
                   :text="section.text"
                   :header="section.header"
                   class="section-margin"/>
        <comment-section :comments="blog.comments"/>
    </div>
</template>

<script>
import router from "../../router";
import TextSection from "./sections/TextSection";
import ImageSection from "./sections/ImageSection";
import CommentSection from "./CommentSection";


export default {
    name: "BlogShow",
    components: {CommentSection, TextSection, ImageSection},
    data() {
        return {
            id: router.currentRoute.params.id,
            blog: {},
            sections: []
        }
    },
    mounted() {
        axios.get('/api/blog/' + this.id)
            .then(r => {
                //console.log(r)
                this.blog = r.data
                this.blog.comments = this.blog.comments.map(com => {
                    com.disabled = true
                    return com
                })
                this.buildSectionArray()
            })
            .catch(e => {
                router.push({name: 'not-found'})
            })
    },
    methods: {
        storage(path) {
            return 'storage/' + path
        },
        buildSectionArray() {
            let textSections = this.blog.text_sections
            let imageSections = this.blog.image_sections

            textSections.forEach(section => {
                section.type = TextSection
                this.sections.push(section)
            })

            imageSections.forEach(section => {
                section.type = ImageSection
                this.sections.push(section)
            })

            this.sections.sort((a, b) => a.index > b.index ? 1 : -1)
        }
    }

}
</script>

<style scoped>
.blog-container {
    max-width: 700px;
    margin: 50px auto;
    padding: 40px;
    background-color: #202c41;
    color: #EBE8EF;
}
.section-margin {
    margin: 30px 0;
}
</style>
