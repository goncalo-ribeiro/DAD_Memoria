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

const example = Vue.component('example', require('./components/example.vue'));
const memoria = Vue.component('memoria', require('./components/memoria.vue'));
const statistics = Vue.component('statistics', require('./components/statistics.vue'));
const login = Vue.component('login', require('./components/login.vue'));
const admin = Vue.component('admin', require('./components/admin/adminConfig.vue'));
const users = Vue.component('users', require('./components/admin/listUsers.vue'));

const routes = [
  { path: '/', redirect: '/memoria' },
  { path: '/example', component: example },
  { path: '/statistics', component: statistics },
  { path: '/memoria', component: memoria },
  { path: '/login', component: login },
  { path: '/admin', component: admin },
  { path: '/users', component: users }
];

const router = new VueRouter({
  routes:routes
});

const app = new Vue({
    router,
    data:{
        accessToken: '',
        admin: false,
        loggedIn: false,
        accessToken: '',
    }
}).$mount('#app');
