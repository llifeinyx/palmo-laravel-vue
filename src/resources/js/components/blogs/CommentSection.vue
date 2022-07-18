<template>
    <div>
        <div>
            <h4>Comment section:</h4>
        </div>
        <p v-if="inputError" style="color: #e03d62">Text field must be required!</p>
        <p v-if="antispamError" style="color: #e03d62">Antispam guard!</p>
        <div class="input-group">
            <input @keydown.enter="addComment" v-model="input" @input="resetErrors" type="text" class="form-control" placeholder="Write comment">
            <button @click="addComment" class="btn btn-outline-primary" type="button">Send</button>
        </div>
        <div class="m-4" v-for="comment in comments">
            <p style="color: #9571FC">{{comment.user_id}}</p>
            <p>{{comment.text}}</p>
            <hr>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import router from "../../router";

export default {
    name: "CommentSection",
    computed: {
        ...mapGetters(["stateUser"]),
    },
    data() {
        return {
            antispam: false,
            antispamError: false,
            input: '',
            inputError: false,
            //comments: []
        }
    },
    props: {
        comments: []
    },
    methods: {
        resetErrors() {
            this.inputError = false
            this.antispamError = false
        },
        addComment() {
            if (!this.stateUser) {
                router.push({name: 'auth.login'})
                return false
            }

            if (!this.input) {
                this.inputError = true
                return false
            }

            if (this.antispam) {
                this.antispamError = true
                return false
            }

            //antispam protection
            this.antispam = true
            setTimeout(() => this.antispam = false, 2500)

            const comment = {
                text: this.input,
                blog_id: +router.currentRoute.params.id,
            }

            if (false) {
                comment.reply_to = '?'
            }

            axios.post('/api/comments/', comment)
                .then(r => {
                    this.comments.push({user: this.stateUser, text: this.input})
                })
                .catch(e => console.log(e.response))
        }
    }
}
</script>

<style scoped>

</style>
