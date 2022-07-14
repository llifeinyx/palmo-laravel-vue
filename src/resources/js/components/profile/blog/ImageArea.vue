<template>
    <div>
        <label :for="id" class="upload-zone">
            <div>upload image</div>
            <div v-if="error" style="color: #f84848">Image too large</div>
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
        path: null,
        show: false,
    },
    data() {
        return {
            error: null,
            image: this.path,
            showPreview: this.show,
        }
    },
    mounted() {
        if (this.path) {
            axios.get(this.path, {
                responseType: "blob"
            })
                .then(r => {
                    const blob = new Blob([r.data]);
                    blob.lastModifiedDate = new Date()
                    let filename = this.path.split('/')
                    filename = filename[filename.length - 1]
                    const image = new File([blob], filename, {
                        type: r.headers['content-type']
                    })
                    this.$emit('upload-file', {file: image, id: this.id})
                    let reader  = new FileReader();

                    let that = this
                    reader.readAsDataURL(image)
                    reader.onload = function (event) {
                        that.showPreview = true
                        that.image = this.result
                    }
                })
        }
    },
    methods: {
        checkFile(event) {
            let image = event.target.files[0]
            if (image.size > 1200000) {
                this.error = true
                setTimeout(() => this.error = null, 3000)
                return false
            }

            this.$emit('upload-file', {file: image, id: this.id})
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
