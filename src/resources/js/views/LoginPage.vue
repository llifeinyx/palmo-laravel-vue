<template>
<div>
    <section class="register-container">
        <login/>
    </section>
</div>
</template>

<script>
import Login from "../components/auth/Login";

export default {
    name: "LoginPage",
    components: {Login}
}
</script>

<style scoped>
    .register-container {
        width: 100%;
        padding-top: 10vh;
    }
</style>
