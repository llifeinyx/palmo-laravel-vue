<template>
<div class="modal-logout">
    <div class="modal-logout__wrapper">
        <div class="logout">
            <h1>Do you really want to logout?</h1>
            <div class="logout__button-group">
                <button @click="closeLogout" class="btn btn-dark">No</button>
                <button @click="acceptLogout" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "ModalLogout",
    methods: {
        closeLogout() {
           this.$emit("close-logout")
        },
        acceptLogout() {
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
.modal-logout {
    z-index: 100;
    position: absolute;
    width: 100vw;
    height: 100vh;
    right: 0;
    bottom: 0;
    left: 0;
    top: 0;
    backdrop-filter: blur(3px);
}
.modal-logout__wrapper {
    padding: 30px;
    width: 400px;
    height: 300px;
    position: relative;
    color: #EBE8EF;
    border-radius: 20px;
    background-color: #191a28;
    top: 50%;
    right: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.logout {
    position: relative;
}
.logout__button-group {
    margin: 50px 50px;
    display: flex;
    justify-content: space-between;
}
.logout__button-group > button {
    font-size: 26px;
    border-radius: 10px;
}
</style>
