<template>
<div>
    <div class="row">
        <router-link :to="{name: 'get'}">Get</router-link>
        <router-link :to="{name: 'auth.login'}">Login</router-link>
        <router-link :to="{name: 'auth.register'}">Register</router-link>
        <a @click.prevent="logout" href="#">Logout</a>
    </div>
    <div class="row">
        <h1>Welcome</h1>
    </div>
</div>
</template>

<script>
export default {
    name: "MainPage",
    methods: {
        logout(){
            axios.post('/logout')
                .then(r => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push('/')
                        .then(r => location.reload())
                        .catch(e => location.reload())
                })
        }
    }
}
</script>

<style scoped>

</style>
