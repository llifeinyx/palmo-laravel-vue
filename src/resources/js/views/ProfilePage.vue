<template>
    <div class="profile-container">
        <div class="content-container">
            <div class="tab-control">
                <div @click="updateCurrentComponent(0)" class="tab-control__button">
                    Profile
                </div>
                <div @click="updateCurrentComponent(1)" class="tab-control__button">
                    My favorite
                </div>
                <div @click="updateCurrentComponent(2)" class="tab-control__button">
                    Create blog
                </div>
            </div>
            <div class="tab-current">
                <keep-alive>

                    <component :is="currentComponent"/>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script>
import Profile from "../components/profile/Profile";

export default {
    name: "ProfilePage",
    data() {
        return {
            currentComponent: Profile
        }
    },
    methods: {
        updateCurrentComponent(id) {
            if (id === 0) {
                this.currentComponent = Profile
            } else if (id === 1) {
                this.currentComponent = null
            } else if (id === 2) {
                this.currentComponent = null
            }
        }
    }
}
</script>

<style scoped>
.profile-container {
    padding-top: 10vh;
}
.content-container {
    margin: 0 auto;
    max-width: 1280px;
    min-height: 500px;

    background-color: #282A41;
    color: #EBE8EF;

    display: flex;
}
.tab-control {
    min-width: 250px;
    border-right: solid 1px #0d1a2f;
}
.tab-control__button {
    padding: 5px 10px;
    border-bottom: solid 1px #0d1a2f;
    font-size: 20px;
}
.tab-control__button-active {
    background-color: #9571FC;
}
.tab-control__button:hover {
    cursor: pointer;
    background-color: #5b5b5b;
    transition: background-color, .2s;
}
</style>
