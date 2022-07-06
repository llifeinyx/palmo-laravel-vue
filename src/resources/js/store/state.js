import Vue from "vue";
import Vuex from "vuex";
import getters from "./getters";

//import {createStore} from "vuex"

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('x_xsrf_token'),
    },
    getters
})
