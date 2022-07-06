<template>
    <div class="header-container">
        <div class="content-container">
            <div class="header-logo">
                <a href="http://example.palmo/"><img src="/assets/logo_cde.svg" alt="logo"></a>
            </div>

            <div class="auth-group">
                <router-link v-if="!stateToken" :class="[this.currentRouteLogin ? 'btn-secondary' : 'btn-dark']" class="btn auth-group__button" :to="{name: 'auth.login'}">Login in</router-link>
                <router-link v-if="!stateToken" :class="[this.currentRouteRegister ? 'btn-secondary' : 'btn-dark']" class="btn auth-group__button" :to="{name: 'auth.register'}">Sign up</router-link>
                <router-link v-if="stateToken" class="btn btn-dark auth-group__button" :to="{name: 'profile'}">Profile</router-link>
                <a v-if="stateToken" class="btn auth-group__button btn-dark" @click.prevent="logout" href="#">Logout</a>
            </div>
        </div>
    </div>
</template>

<script>
//import {next} from "lodash/seq";
import {mapGetters} from "vuex";

export default {
    name: "Header",
    data() {
        return {
            currentRoute: window.location.pathname,
        }
    },
    // beforeRouteUpdate (to, from) {
    //     this.currentRoute = to.path;
    //     next()
    // },
    computed: {
        ...mapGetters(["stateToken"]),
        currentRouteLogin: function () {
            return this.currentRoute === '/login';
        },
        currentRouteRegister: function () {
            return this.currentRoute === '/register';
        }
    },
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
.header-container {
    width: 100%;

    background: linear-gradient(to right, #ae97ec, #784ef3);
}
.content-container {
    min-height: 50px;
    margin: 0 auto;
    max-width: 1440px;

    display: flex;
    justify-content: space-between;
    align-items: center;
}
.auth-group__button {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 10px;
}

</style>
