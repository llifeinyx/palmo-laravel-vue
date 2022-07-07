<template>
<div>
    <Header/>
    <router-view/>
</div>
</template>

<script>
import Header from "./Header";

export default {
    name: "Index",
    components: {Header}
}
</script>

<style>
    body {
        position: relative;
        background-color: #cbcbcb;
        font-family: Roboto, sans-serif;
    }
</style>
