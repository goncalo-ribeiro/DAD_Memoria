/*jshint esversion: 6 */
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueSocketio from 'vue-socket.io';

Vue.use(VueRouter);

Vue.use(VueSocketio, 'http://127.0.0.1:8080');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const memoria = Vue.component('memoria', require('./components/game/memoria.vue'));
const replay = Vue.component('replay', require('./components/replay/replayMemoria.vue'));
const statistics = Vue.component('statistics', require('./components/statistics.vue'));
const login = Vue.component('login', require('./components/login.vue'));
const signup = Vue.component('signup', require('./components/signup.vue'));
const admin = Vue.component('admin', require('./components/admin/adminConfig.vue'));
const users = Vue.component('users', require('./components/admin/listUsers.vue'));
const reset = Vue.component('reset', require('./components/admin/resetPassword.vue'));
const image = Vue.component('image', require('./components/admin/imageManagement.vue'));
const error = Vue.component('error', require('./components/error.vue'));

const routes = [
  { path: '/', redirect: '/memoria' },
  { path: '/statistics', component: statistics },
  { path: '/memoria', component: memoria},
  { path: '/replay', component: replay },
  { path: '/login', component: login },
  { path: '/signup', component: signup },
  { path: '/admin', component: admin },
  { path: '/users', component: users },
  { path: '/reset', component: reset },
  { path: '/images', component: image },
  { path: '/error', component: error },
];

const router = new VueRouter({
  routes:routes
});

router.beforeEach((to, from, next) => {
  console.log(to);
})

const app = new Vue({
    router,
    data:{
        accessToken: '',
        admin: false,
        loggedIn: false,
        accessToken: '',
        resetToken: token,
        loggedUser: null,
    }
}).$mount('#app');
