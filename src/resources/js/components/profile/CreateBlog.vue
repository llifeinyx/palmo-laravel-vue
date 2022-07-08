<template>
    <div class="create-blog-container">
        <div class="create-panel">
            <h4>Create sections:</h4>
            <div @click="addTextSection" class="create-panel__element">
                text
            </div>
            <div v-if="textError" class="section-error">
                {{textError}}
            </div>
            <div @click="addImageSection" class="create-panel__element">
                image
            </div>
            <div v-if="imageError" class="section-error">
                {{imageError}}
            </div>
        </div>
        <div class="create-area">
            <div class="create-zone">
                <div class="input-card" v-for="section in sections">
                    <component @delete-image-section="deleteImageSection" @delete-text-section="deleteTextSection" @set-header="setHeader" @set-text="setText" :is="section.type" :key="section.id" :id="section.id"/>
                </div>
            </div>
        </div>
        <div class="last-area">
            <div>
                <h4>Title of blog:</h4>
                <input type="text" name="title" id="title" placeholder="Maximum 20 characters">
            </div>
            <div>
                <h4>Tags:</h4>
                <div class="input-tags">
                    <div class="input-tags__wrapper">
                        <div class="suggested-tag current-tag" v-for="currentTag in currentTags" @click="deleteCurrentTag(currentTag)"><span>{{currentTag.name}}</span><span class="special-char__red">-</span></div>
                        <div class="suggested-tag" v-for="suggestedTag in suggestedTags" @click="addCurrentTag(suggestedTag)"><span>{{suggestedTag.name}}</span><span class="special-char__green">+</span></div>
                    </div>
                </div>
                <div v-if="tagError" class="section-error">Maximum 5 tags!</div>
                <input v-model="tag" type="text" name="tags" id="tags" placeholder="Tags">
            </div>
            <div class="submit-blog">
                <button @click="createBlog" class="btn btn-outline-primary">create blog</button>
            </div>
        </div>
    </div>
</template>

<script>
import TextArea from "./blog/TextArea";
import ImageArea from "./blog/ImageArea";

export default {
    name: "CreateBlog",
    components: {TextArea, ImageArea},
    data() {
        return {
            tag: null,
            tags: [],
            suggestedTags: [],
            currentTags: [],
            tagError: false,
            countCurrentTags: 0,
            textError: null,
            imageError: null,
            countImageSections: 0,
            countTextSections: 0,
            listId: 0,
            sections: [
            ]
        }
    },
    mounted() {
        axios.get('/api/tags')
            .then(r => {
                this.tags = r.data
                this.suggestedTags = r.data
            })
    },
    watch: {
        tag: function (val) {
            this.suggestedTags = this.tags.filter(tag => {
                if (this.currentTags.includes(tag.name)){
                    return false
                }
                if (tag.name.includes(val.toLowerCase())) {
                    return tag
                }
            })
        }
    },
    methods: {
        setText(event) {
            let textSection = this.sections.find(section => section.id === event.id)
            textSection.text = event.text
        },
        setHeader(event) {
            let textSection = this.sections.find(section => section.id === event.id)
            textSection.header = event.header
        },
        deleteTextSection(event) {
            this.sections.find((section, index) => {
                if (section.id === event.id) {
                    this.sections.splice(index, 1)
                    this.countTextSections--
                    return
                }
            })
        },
        addTextSection() {
            if (this.countTextSections === 5) {
                this.textError = 'Maximum 5 text sections!'
                setTimeout(() => this.textError = null, 1000)
                return
            }

            this.countTextSections++
            this.sections.push({id: this.listId, type: TextArea, text: null})
            this.listId++
        },
        deleteImageSection(event) {
            this.sections.find((section, index) => {
                if (section.id === event.id) {
                    this.sections.splice(index, 1)
                    this.countImageSections--
                    return
                }
            })
        },
        addImageSection() {
            if (this.countImageSections === 5) {
                this.imageError = 'Maximum 5 image sections!'
                setTimeout(() => this.imageError = null, 3000)
                return
            }
            this.countImageSections++
            this.sections.push({id: this.listId, type: ImageArea})
            this.listId++
        },
        addCurrentTag(tagObj) {
            if (this.countCurrentTags === 5) {
                this.tagError = true
                setTimeout(() => this.tagError = false, 3000)
                return
            }

            const index = this.suggestedTags.indexOf(tagObj)
            this.suggestedTags.splice(index, 1)

            this.currentTags.push(tagObj)
            this.countCurrentTags++
        },
        deleteCurrentTag(tagObj) {
            const index = this.currentTags.indexOf(tagObj)
            this.currentTags.splice(index, 1)

            this.suggestedTags.push(tagObj)
            this.countCurrentTags--
        },
        createBlog() {
            const currentTagsId = this.currentTags.map(tagObj => tagObj.id)
            axios.post('/api/blog', {tags: currentTagsId})
                .then(r => console.log(r))
                .catch(e => console.log(e.response))
        }
    }
}
</script>

<style scoped>
.create-blog-container {
    display: flex;
}
.create-panel {
    padding: 10px;
    min-width: 250px;
    min-height: 500px;
    border-right: solid 1px #0d1a2f;
}
.create-panel > h4 {
    margin-bottom: 20px;
}
.create-panel__element {
    text-align: center;
    font-size: 18px;
    color: #EBE8EF;
    padding: 3px 5px;
    background-color: #9571FC;
    border-radius: 5px;
    margin: 15px 0;
}
.create-panel__element:hover {
    cursor: pointer;
    background-color: #722d9b;
    transition: background-color, .2s;
}
.create-area {
    overflow-y: scroll;
    height: 500px;
    display: flex;
    justify-content: center;
    min-width: 500px;
    border-right: solid 1px #0d1a2f;
}
.create-zone {
    padding-top: 10px;
    display: block;
}
.input-card {
    margin: 5px 0;
}
.section-error {
    color: #e53051;
}
::-webkit-scrollbar {
    width: 2px;
    background-color: #9571FC;
}
::-webkit-scrollbar-thumb {
    background-color: #180b3d;
}
.last-area {
    padding: 10px;
    position: relative;
}
.input-tags {
    overflow-y: scroll;
    margin-bottom: 10px;
    padding: 5px;
    color: #000;
    width: 250px;
    height: 125px;
    background-color: #EBE8EF;
}
.input-tags__wrapper {
    display: flex;
    flex-direction: row;
    flex-flow: wrap;
    gap: 5px;
}
.suggested-tag {
    text-align: center;
    font-size: 12px;
    padding: 0 7px;
    background-color: #9571FC;
    border-radius: 5px;
    height: 20px;
}
.suggested-tag:hover {
    cursor: pointer;
    background-color: #722d9b;
    transition: background-color, .2s;
    color: #EBE8EF;
}
.special-char {
    font-weight: 1000;
    margin-left: 4px;
    text-align: center;
    font-size: 12px;
}.special-char__red {
    margin-left: 4px;
    color: #ee3333;
}
.special-char__green {
    color: #2a8544;
}
.current-tag {
    background-color: #722d9b;
    color: #EBE8EF;
}
.submit-blog {
    margin: 20px 0;
}
</style>