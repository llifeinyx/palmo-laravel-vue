<template>
    <div class="create-blog-container">
        <div class="create-panel">
            <h4>Update sections:</h4>
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
                <draggable v-model="sections">
                    <component class="input-card" v-for="section in sections"
                               :key="section.id"
                               @upload-file="uploadFile"
                               @delete-image-section="deleteImageSection"
                               @delete-text-section="deleteTextSection"
                               @set-header="setHeader"
                               @set-text="setText"
                               :p_text="section.text"
                               :p_header="section.header"
                               :path="'/storage/' + section.path"
                               :show="true"
                               :is="section.type"
                               :id="section.id"/>
                </draggable>
            </div>
        </div>
        <div class="last-area">
            <div>
                <div v-if="successCreate" class="success">Success create blog!</div>
                <div v-if="textSectionInnerError" class="section-error">{{ textSectionInnerError }}</div>
                <div v-if="textSectionError" class="section-error">{{ textSectionError }}</div>
                <h4>Title of blog:</h4>
                <input v-model="title" type="text" name="title" id="title" placeholder="Maximum 20 characters">
                <div v-if="titleErrors" class="section-error">{{ titleErrors }}</div>
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
                <div v-if="tagErrors" class="section-error">{{ tagErrors }}</div>
                <input v-model="tag" type="text" name="tags" id="tags" placeholder="Tags">
            </div>
            <div class="submit-blog">
                <button @click="createBlog" class="btn btn-outline-primary">update blog</button>
            </div>
        </div>
    </div>
</template>

<script>
import TextArea from "../profile/blog/TextArea";
import ImageArea from "../profile/blog/ImageArea";
import router from "../../router";

import draggable from "vuedraggable";

export default {
    name: "BlogUpdate",
    components: {TextArea, ImageArea, draggable},
    data() {
        return {
            blogId: router.currentRoute.params.id,
            formData: new FormData(),
            tag: null,
            tags: [],
            title: null,
            suggestedTags: [],
            currentTags: [],
            tagError: false,
            countCurrentTags: 0,
            textError: null,
            imageError: null,
            textSectionError: null,
            textSectionInnerError: null,
            countImageSections: 0,
            countTextSections: 0,
            listId: 0,
            sections: [
            ],
            tagErrors: null,
            titleErrors: null,
            successCreate: null
        }
    },
    mounted() {
        axios.get('/api/tags')
            .then(r => {
                this.tags = r.data.map(tag => {
                    delete tag.id
                    return tag
                })
                axios.get('/api/blog/' + this.blogId)
                    .then(r => {
                        const blog = r.data
                        this.title = blog.title
                        for (let tag of blog.tags) {
                            delete tag.pivot
                            delete tag.id
                            this.addCurrentTag(tag)
                        }
                        this.tags.forEach(tag => {
                            let result = this.currentTags.find(currentTag => currentTag.name === tag.name)

                            if (!result) {
                                this.suggestedTags.push(tag)
                            }
                        })

                        for (let imageSection of blog.image_sections) {
                            imageSection.type = ImageArea
                            this.sections.push(imageSection)

                        }
                        for (let textSection of blog.text_sections) {
                            textSection.type = TextArea
                            this.sections.push(textSection)

                        }
                        this.sections.sort((a, b) => a.index > b.index ? 1 : -1)

                        for (let section of this.sections) {
                            section.id = this.listId++
                        }
                    })
                    .catch(e => console.log(e.response))
            })
    },
    watch: {
        // tag: function (val) {
        //     this.suggestedTags = this.tags.filter(tag => {
        //         if (this.currentTags.includes(tag.name)){
        //             return false
        //         }
        //         if (tag.name.includes(val.toLowerCase())) {
        //             return tag
        //         }
        //     })
        // }
        tag: function (val) {
            if (val.length > 12) {
                this.tagErrors = 'Name of tag maximum 12 characters!'
                val = val.slice(0, 12)
            } else {
                this.tagErrors = null
            }

            let boolPush = false
            this.suggestedTags = this.tags.filter(tag => {
                if (tag.name.toLowerCase() === val.toLowerCase()) {
                    boolPush = true
                }
                if (this.currentTags.find(currentTag => currentTag.name.toLowerCase() === val.toLowerCase())) {
                    boolPush = true
                }

                if (this.currentTags.includes(tag)){
                    return false
                }

                if (tag.name.includes(val.toLowerCase())) {
                    return tag
                }
            })
            if (!val) {
                return false
            }

            if (!boolPush) {
                this.suggestedTags.push({name: val})
            }
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
            const index = this.sections.findIndex(obj => obj.id === event.id)

            this.sections.splice(index, 1)
            this.countTextSections--
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
            const index = this.sections.findIndex(obj => obj.id === event.id)
            this.sections.splice(index, 1)
            this.countImageSections--
        },
        addImageSection() {
            if (this.countImageSections === 5) {
                this.imageError = 'Maximum 5 image sections!'
                setTimeout(() => this.imageError = null, 3000)
                return
            }
            this.countImageSections++
            this.sections.push({id: this.listId, file: '',type: ImageArea})
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
        uploadFile(event) {
            const i = this.sections.findIndex(section => {
                if (section.id === event.id && section.type === ImageArea) {
                    return true
                }
            })
            this.sections[i].file = event.file
        },
        createBlog() {
            //push current tags
            this.currentTags.forEach(tag => {
                this.formData.append('tags[]', tag.name)
            })

            //push sections
            this.sections.forEach((section, index) => {
                //push text sections
                if (section.type === TextArea) {
                    if (section.text){
                        this.formData.append('textSections[' + index + '][text]', section.text)
                    }
                    if (section.header) {
                        this.formData.append('textSections[' + index + '][header]', section.header)
                    }
                    this.formData.append('textSections[' + index + '][id]', index)
                }
                //push image sections
                if (section.type === ImageArea) {
                    if(section.file !== ""){
                        this.formData.append('files[' + index + '][file]', section.file)
                        this.formData.append('files[' + index + '][id]', index)
                    }
                }
            })

            //push title
            if (this.title) {
                this.formData.append('title', this.title)
            }
            this.formData.append("_method", "put");
            const url = '/api/blog/' + this.blogId
            axios.post(url, this.formData)
                .then(r => {
                    this.successCreate = true
                    setTimeout(() => this.successCreate = null, 3000)
                    router.push('/blog/' + r.data)
                })
                .catch(e => {
                    console.log(e.response)
                    let errors = e.response.data.errors
                    if (errors.tags) {
                        this.tagErrors = errors.tags[0]
                        delete errors.tags
                        setTimeout(() => this.tagErrors = null, 3000)
                    }
                    if (errors.title) {
                        this.titleErrors = errors.title[0]
                        delete errors.title
                        setTimeout(() => this.titleErrors = null, 3000)
                    }
                    if (errors.textSections) {
                        this.textSectionError = errors.textSections[0]
                        delete errors.textSections
                        setTimeout(() => this.textSectionError = null, 3000)
                    }
                    const keys = Object.keys(errors)
                    keys.forEach((key) => {
                        if (key.includes('textSections.')) {
                            this.textSectionInnerError = 'Header and text fields in text section required!'
                            setTimeout(() => this.textSectionInnerError = null, 3000)
                        }
                    })
                    //console.log(e.response)
                })

            //reset formData
            this.formData = new FormData()
        },
    }
}
</script>

<style scoped>
.create-blog-container {
    max-width: 1280px;
    min-height: 800px;
    margin: 50px auto;
    display: flex;
    background-color: #2d3748;
    color: #fff;
}
.create-panel {
    padding: 10px;
    min-width: 250px;
    min-height: 800px;
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
    height: 800px;
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

