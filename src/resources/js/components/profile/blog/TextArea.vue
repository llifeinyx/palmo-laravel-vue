<template>
    <div>
        <div>
            <div>
                <label :for="id">Header for text section</label>
            </div>
            <textarea @input="$emit('set-header', {id:id, header: header})" v-model="header" :name="'header[]'" :id="'header' + id" cols="40" rows="1"></textarea>
        </div>
        <div>
            <label :for="id">Text section</label>
        </div>
        <textarea @input="$emit('set-text', {id:id, text: text})" v-model="text" :name="'text[]'" :id="id" cols="40" rows="10"></textarea>
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
          text: null,
          header: null,
      }
    },
    props: {
        id: null,
    }
}
</script>

<style scoped>
.btn-delete {
    position: relative;
    width: 100%;
}
</style>
