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
        <div class="у">

        </div>
    </div>
</template>

<script>
import TextArea from "./blog/TextArea";
import ImageArea from "./blog/ImageArea";
import {list} from "postcss";

export default {
    name: "CreateBlog",
    components: {TextArea, ImageArea},
    data() {
        return {
            textError: null,
            imageError: null,
            countImageSections: 0,
            countTextSections: 0,
            listId: 0,
            sections: [
            ]
        }
    },
    methods: {
        setText(event) {
            //console.log(event)
            let textSection = this.sections.find(section => section.id === event.id)
            textSection.text = event.text
        },
        setHeader(event) {
            //console.log(event)
            let textSection = this.sections.find(section => section.id === event.id)
            textSection.header = event.header
        },
        deleteTextSection(event) {
            this.sections.find((section, index) => {
                if (section.id === event.id) {
                    this.sections.splice(index, 1)
                }
            })
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
            this.sections.find((section, index) => {
                if (section.id === event.id) {
                    this.sections.splice(index, 1)
                }
            })
            this.countImageSections--
        },
        addImageSection() {
            if (this.countImageSections === 5) {
                this.imageError = 'Maximum 5 image sections!'
                setTimeout(() => this.imageError = null, 1000)
                return
            }
            this.countImageSections++
            this.sections.push({id: this.listId, type: ImageArea})
            this.listId++
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
</style>
