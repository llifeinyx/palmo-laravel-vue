<template>
<div>
    <section class="register-container">
        <register/>
    </section>
</div>
</template>

<script>
import Register from "../components/auth/Register";

export default {
    name: "RegisterPage",
    components: {Register}
}
</script>

<style scoped>
    .register-container {
        width: 100%;
        padding-top: 20vh;
    }
</style>
