<template>
    <div>
        <div>
            <div>
                <label :for="id">Header for text section</label>
            </div>
            <textarea @input="$emit('set-header', {id:id, header: header})" v-model="header" :name="'header[]'" :id="'header' + id" cols="40" rows="1">{{header}}</textarea>
        </div>
        <div>
            <label :for="id">Text section</label>
        </div>
        <textarea @input="$emit('set-text', {id:id, text: text})" v-model="text" :name="'text[]'" :id="id" cols="40" rows="10">{{text}}</textarea>
        <div>
            <button @click="$emit('delete-text-section', {id: id})" class="btn btn-outline-danger btn-delete">Delete text section</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "TextArea",
    data() {
      return {
          text: this.p_text,
          header: this.p_header,
      }
    },
    props: {
        id: null,
        p_text: null,
        p_header: null
    }
}
</script>

<style scoped>
.btn-delete {
    position: relative;
    width: 100%;
}
</style>
