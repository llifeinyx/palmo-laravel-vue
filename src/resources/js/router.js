import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
   mode: "history",
   routes: [
       {
         path: '/',
         component: () => import('./views/MainPage'),
         name: 'main'
       },
       {
           path: '/get',
           component: () => import('./components/Get'),
           name: 'get'
       },
       {
           path: '/login',
           component: () => import('./views/LoginPage'),
           name: 'auth.login'
       },
       {
           path: '/register',
           component: () => import('./views/RegisterPage'),
           name: 'auth.register'
       },
       {
           path: '/profile',
           component: () => import('./views/ProfilePage'),
           name: 'profile'
       },
       {
           path: '/blog/:id',
           component: () => import('./components/blogs/BlogShow'),
           name: 'blog.show'
       },
       {
           path: '*',
           component: () => import('./components/abort/NotFound404'),
           name: 'not-found'
       }
   ]
});

import AuthMiddleware from "./middleware/auth.js"
import BlogShow from "./components/blogs/BlogShow";

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')

    AuthMiddleware(token, to, from, next)
})

export default router
