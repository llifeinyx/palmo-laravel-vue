<template>
    <div class="profile-component-container">
        <h1>{{user.name}} profile</h1>
        <div class="profile-update-group">
            <div class="input-group">
                <label for="name">Login</label>
                <input @input="resetResponseStatus" v-model="user.name" type="text" id="name" class="form-control" placeholder="Login" aria-label="Login">
                <div v-if="this.responseStatus === 200" class="success-update">Success update</div>
                <div v-if="this.responseStatus !== 200" class="error-update">{{error}}</div>
            </div>
        </div>
        <div class="profile-update-submit">
            <button @click="updateProfile" class="btn btn-outline-primary">Update profile</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Profile",
    data() {
        return {
            user: {},
            error: null,
            responseStatus: null
        }
    },
    mounted() {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get('/api/user')
                .then(r => this.user = r.data)
        });
    },
    methods: {
        updateProfile() {
            axios.put('/api/user/' + this.user.id, this.user)
                .then(r => {
                    //console.log(r.status)
                    this.user = r.data
                    this.responseStatus = r.status
                })
                .catch(e => {
                    console.log(e.response)
                    this.responseStatus = e.response.status
                    this.error = e.response.data.message
                })
        },
        resetResponseStatus() {
            this.responseStatus = null
        }
    }
}
</script>

<style scoped>
.profile-component-container {
    padding: 20px 20px;
}
.profile-update-group {
    padding: 100px 0;
}
.input-group {
    display: block;
    font-size: 24px;
}
.input-group > .form-control {
    margin-top: 5px;
    min-width: 200px;
}
.success-update {
    margin-top: 8px;
    font-size: 12px;

    color: #54b63f;
}
.error-update {
    margin-top: 8px;
    font-size: 12px;

    color: #c02849;
}
</style>
