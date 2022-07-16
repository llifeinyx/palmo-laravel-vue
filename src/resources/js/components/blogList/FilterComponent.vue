<template>
    <div class="filter-container">
        <div>
            <button @click="sortByNewest" class="filter-button btn btn-dark">Sort by newest</button>
        </div>
        <div class="tag-filter">
            <input v-model="tag" type="text" name="tags" id="tags" placeholder="Tags">
            <div class="tag-area">
                <div class="suggested-tag current-tag" v-for="currentTag in currentTags" @click="deleteCurrentTag(currentTag)"><span>{{currentTag.name}}</span><span class="special-char__red">-</span></div>
                <div class="suggested-tag" v-for="suggestedTag in suggestedTags" @click="addCurrentTag(suggestedTag)"><span>{{suggestedTag.name}}</span><span class="special-char__green">+</span></div>
            </div>
        </div>
    </div>
</template>

<script>
import Tag from "../miscellanea/Tag";

export default {
    name: "FilterComponent",
    components: {Tag},

    mounted() {
        axios.get('/api/tags')
            .then(r => {
                this.tags = r.data
                this.suggestedTags = this.tags
            })
    },
    data() {
        return {
            tag: null,
            tags: [],
            suggestedTags: [],
            currentTags: [],
        }
    },
    methods: {
        sortByNewest() {
            this.$emit('sort-by-newest')
        },
        addCurrentTag(tagObj) {
            const index = this.suggestedTags.indexOf(tagObj)
            this.suggestedTags.splice(index, 1)

            this.currentTags.push(tagObj)
            this.$emit('filter-by-tags', this.currentTags)
        },
        deleteCurrentTag(tagObj) {
            const index = this.currentTags.indexOf(tagObj)
            this.currentTags.splice(index, 1)

            this.suggestedTags.push(tagObj)
            this.$emit('filter-by-tags', this.currentTags)
        },
    },
    watch: {
        tag: function (val) {
            this.suggestedTags = this.tags.filter(tag => {
                if (this.currentTags.includes(tag)){
                    return false
                }

                if (tag.name.includes(val.toLowerCase())) {
                    return tag
                }
            })
        },
    },
}
</script>

<style scoped>
.filter-container {
    margin: 20px auto;
    padding: 20px 50px;
    color: #EBE8EF;
    background-color: #2d3748;
    display: flex;

    gap: 30px;
    align-items: center;
}
.filter-button {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 10px;
}
.filter-button:active {
    background-color: #9571FC;
}
.tag-filter {
    display: flex;
    align-items: center;
    gap: 15px;
}
.tag-filter > input {
    width: 100px;
}
.tag-area {
    z-index: 10;
    overflow-y: scroll;
    padding: 4px;
    display: flex;
    flex-flow: wrap;
    gap: 3px;

    width: 350px;
    height: 60px;
    max-width: 350px;
    max-height: 60px;
    background-color: #EBE8EF;
}
::-webkit-scrollbar {
    display: none;
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
.current-tag {
    background-color: #722d9b;
    color: #EBE8EF;
}
</style>
