<template>
    <div class="tag">
        {{name}}
    </div>
</template>

<script>
export default {
    name: "Tag",
    props: {
        name: null,
    }
}
</script>

<style scoped>
.tag {
    text-align: center;
    font-size: 12px;
    padding: 0 7px;
    background-color: #9571FC;
    border-radius: 5px;
    height: 20px;
}
.tag:hover {
    cursor: pointer;
    background-color: #722d9b;
    transition: background-color, .2s;
    color: #EBE8EF;
}
</style>
