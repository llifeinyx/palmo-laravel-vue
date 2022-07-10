<template>
    <div class="blog-container">
        <component v-for="section in sections"
                   :is="section.type"
                   :key="section.id"
                   :path="section.path"
                   :text="section.text"
                   :header="section.header"/>
    </div>
</template>

<script>
import router from "../../router";
import TextSection from "./sections/TextSection";
import ImageSection from "./sections/ImageSection";


export default {
    name: "BlogShow",
    components: {TextSection, ImageSection},
    data() {
        return {
            id: router.currentRoute.params.id,
            blog: null,
            sections: []
        }
    },
    mounted() {
        axios.get('/api/blog/' + this.id)
            .then(r => {
                //console.log(r)
                this.blog = r.data
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
    max-width: 1280px;
    margin: 50px auto;
}
</style>
