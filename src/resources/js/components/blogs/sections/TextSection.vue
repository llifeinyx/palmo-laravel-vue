<template>
    <div>
        <hr>
        <div class="text-section text-section__header">
            {{header}}
        </div>
        <div class="text-section text-section__text">
            {{text}}
        </div>
        <hr>
    </div>
</template>

<script>
export default {
    name: "TextSection",
    props: {
        header: null,
        text: null
    }
}
</script>

<style scoped>
.text-section {
    color: #EBE8EF;
    margin: 20px;
}
.text-section__header {
}
.text-section__text {

}
</style>
