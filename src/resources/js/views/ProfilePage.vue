<template>
    <div class="profile-container">
        <div class="content-container">
            <div class="tab-control">
                <div :class="{'tab-control__button-active' : currentComponent.name === 'Profile'}" @click="updateCurrentComponent(0)" class="tab-control__button">
                    Profile
                </div>
                <div :class="{'tab-control__button-active' : currentComponent.name === 'CreateBlog'}" @click="updateCurrentComponent(2)" class="tab-control__button">
                    Create blog
                </div>
                <div :class="{'tab-control__button-active' : currentComponent.name === 'MyBlogs'}" @click="updateCurrentComponent(3)" class="tab-control__button">
                    My blogs
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
import CreateBlog from "../components/profile/CreateBlog";
import MyBlogs from "../components/profile/MyBlogs";


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
                this.currentComponent = CreateBlog
            } else if (id === 3) {
                this.currentComponent = MyBlogs
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
    background-color: #722d9b;
    transition: background-color, .2s;
}
</style>
