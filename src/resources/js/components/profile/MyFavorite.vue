<template>
<div>
    <button @click="User">user</button>
</div>
</template>

<script>
import state from "../../store/state";
import {mapGetters} from "vuex";

export default {
    name: "MyFavorite",
    data() {
        return {
            user: null
        }
    },
    computed: {
        ...mapGetters(["stateUser"]),
    },
    methods: {
        User() {
            console.log(this.stateUser)
        }
    }
}
</script>

<style scoped>

</style>
