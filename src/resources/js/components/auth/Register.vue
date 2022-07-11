<template>
    <div class="register-card">
        <div class="register-card__head">
            <div>Registration</div>
            <div class="register-card__head-propose">Have already<br><router-link :to="{name: 'auth.login'}" style="text-decoration: underline">been registered?</router-link></div>
        </div>
        <div class="register-card__input">
            <label for="email">Email</label>
            <input v-model="email" type="text" id="email" class="form-control" placeholder="Email" aria-label="Email">
            <div v-if="errors.email" class="register-card__input-error"> {{errors.email[0]}} </div>
        </div>
        <div class="register-card__input">
            <label for="login">Login</label>
            <input v-model="login" type="text" id="login" class="form-control" placeholder="Login" aria-label="Login">
            <div v-if="errors.name" class="register-card__input-error"> {{errors.name[0]}} </div>
        </div>
        <div class="register-card__input">
            <label for="password">Password</label>
            <input v-model="password" type="password" id="password" class="form-control" placeholder="Password" aria-label="Password">
            <div v-if="errors.password" class="register-card__input-error"> {{errors.password[0]}} </div>
        </div>
        <div class="register-card__input">
            <label for="password-confirmation">Password confirmation</label>
            <input v-model="password_confirmation" type="password" id="password-confirmation" class="form-control" placeholder="Password confirm" aria-label="Password confirm">
            <div v-if="errors.password" class="register-card__input-error"> {{errors.password[1]}} </div>
        </div>
        <input @click.prevent="register" type="submit" class="btn btn-outline-primary register-card__submit" value="Registration">
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Register",
    data(){
        return {
            email: null,
            login: null,
            password: null,
            password_confirmation: null,
            errors: {}
        }
    },

    methods: {
        ...mapActions(['getToken']),
        register(){
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', {
                        email: this.email,
                        name: this.login,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                        .then(r => {
                            localStorage.setItem('x_xsrf_token', r.config.headers['X-XSRF-TOKEN'])
                            this.$router.push('/')
                                .then(r => this.getToken())
                        })
                        .catch(e => {
                            //console.log(e.response)
                            this.errors = e.response.data.errors
                        })
                })
        }
    }
}
</script>

<style scoped>
.register-card {
    margin: 0 auto;

    max-width: 500px;
    min-height: 70vh;

    background-color: #282A41;

    border-radius: 40px;

    padding: 30px 50px;

    color: #EBE8EF;
    font-size: 22px;
    font-family: Roboto, sans-serif;
}
.register-card__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;

    font-size: 32px;

    margin-bottom: 35px;
}
.register-card__head-propose {
    font-size: 20px;
    color: #FFA858;
}
.register-card__input {
    margin-bottom: 15px;
}
.register-card__input-error {
    margin-top: 2px;
    font-size: 16px;
    color: #FF3636;
}
.register-card__submit {
    margin: 20px 0;
    width: 100%;
}
</style>
