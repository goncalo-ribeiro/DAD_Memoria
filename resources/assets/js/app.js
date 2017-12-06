/*jshint esversion: 6 */
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const example = Vue.component('example', require('./components/Example.vue'));
const memoria = Vue.component('memoria', require('./components/memoria.vue'));

const routes = [
  { path: '/', redirect: '/memoria' },
  { path: '/example', component: example },
  { path: '/memoria', component: memoria }
];

const router = new VueRouter({
  routes:routes
});

const app = new Vue({
    router,
    data:{
        
    }
}).$mount('#app');
