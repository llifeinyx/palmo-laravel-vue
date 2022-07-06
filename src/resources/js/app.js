import Vue from "vue";
import Index from "./components/Index";
import router from "./router.js";
import store from './store/state.js';


require('./bootstrap');

new Vue({
    store,
    router,
    render: h => h(Index)
}).$mount('#app');
