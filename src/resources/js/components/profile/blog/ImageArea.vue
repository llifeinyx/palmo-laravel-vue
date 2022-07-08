<template>
    <div>
        <label :for="id" class="upload-zone">
            <div>upload image</div>
            <img class="upload-image" v-bind:src="image" v-show="showPreview" alt="image"/>
        </label>
        <input @change="checkFile($event)" :name="'image[]'" :id="id" :ref="'image' + id" type="file" hidden accept="image/*">
        <div>
            <button @click="$emit('delete-image-section', {id: id})" class="btn btn-outline-danger btn-delete">Delete image section</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ImageArea",
    props: {
        id: null,
    },
    data() {
        return {
            image: null,
            showPreview: false,
        }
    },
    methods: {
        checkFile(event) {
            let image = event.target.files[0];
            //this.image = this.$refs.file;
            let reader  = new FileReader();

            let that = this
            reader.readAsDataURL(image)
            reader.onload = function (event) {
                that.showPreview = true
                that.image = this.result
            }
        }
    }
}
</script>

<style scoped>
.upload-zone {
    position: relative;
    width: 100%;
    padding: 5px 17px;
    border-radius: 10px;
    background-color: #0c5460;
    text-align: center;
}
.upload-zone:hover {
    cursor: pointer;
    background-color: #1da66d;
}
.upload-image {
    image-resolution: normal;
    max-width: 350px;
    max-height: 300px;
}
.btn-delete {
    margin-top: 10px;
    border-radius: 10px;
    position: relative;
    width: 100%;
}
</style>
