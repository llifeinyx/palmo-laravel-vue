<template>
    <div class="register-card">
        <div class="register-card__head">
            <div>Login in</div>
            <div class="register-card__head-propose">Do not have account?<br><router-link :to="{name: 'auth.register'}" style="text-decoration: underline">Create now.</router-link></div>
        </div>
        <div class="register-card__input">
            <label for="email">Email</label>
            <input v-model="email" type="text" id="email" class="form-control" placeholder="Email" aria-label="Email">
            <div v-if="errors.email" class="register-card__input-error"> {{errors.email[0]}} </div>
        </div>
        <div class="register-card__input">
            <label for="password">Password</label>
            <input v-model="password" type="password" id="password" class="form-control" placeholder="Password" aria-label="Password">
            <div v-if="errors.password" class="register-card__input-error"> {{errors.password[0]}} </div>
        </div>
        <div class="register-card__input">
            <label for="remember" class="form-check-label">Remember me</label>
            <input v-model="remember" type="checkbox" id="remember" class="form-check-input" aria-label="remember">
        </div>
        <input @click.prevent="login" type="submit" class="btn btn-outline-primary register-card__submit" value="Login in">
    </div>
</template>

<script>
export default {
    name: "Login",
    data(){
        return{
            email: null,
            password: null,
            remember: null,
            errors: {}
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/login', {email: this.email, password: this.password, remember: this.remember})
                        .then( res => {
                            localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                            this.$router.push('/')
                                .then(r => location.reload())
                        })
                        .catch(e => this.errors = e.response.data.errors)
                });
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
