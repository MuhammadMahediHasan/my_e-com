/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuelidation from 'vuelidation';
import VueSweetalert2 from 'vue-sweetalert2';
import VueLoading from 'vuejs-loading-plugin';
import Loading from './components/backend/Loading';
import {routes} from './router';
import InputTag from 'vue-input-tag';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import { Cropper } from 'vue-advanced-cropper';


Vue.use(VueRouter);
Vue.use(Vuelidation);
Vue.use(VueLoading);
Vue.use(VueSweetalert2);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('nav-bar', require('./components/backend/layouts/NavBar.vue').default);
Vue.component('side-bar', require('./components/backend/layouts/SideBar.vue').default);
Vue.component('footer-sec', require('./components/backend/layouts/Footer.vue').default);
Vue.component('input-tag', InputTag)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//loader
Vue.use(VueLoading, {
    dark: true,
    text: 'Loading',
    loading: true,
    customLoader: Loading,
    background: 'rgb(255,255,255)',
    classes: ['myclass']
});

//Toaster Notification
Vue.use(VueToast, {
    position: 'bottom',
    duration: 1000,
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.mixin({
    data(){
        return {
            baseUrl:"api/"
        }
    },
    methods:{
        Loader : function(){
            this.$loading(true)
            setTimeout(() => this.$loading(false), 1000)
        },
        resetForm() {
            var _this = this;
            var FORM = _this.form;
            Object.keys(FORM).forEach(function (key, index) {
                FORM[key] = '';
            });
        },
    },
    created (){
        this.Loader();
    }
});


const router = new VueRouter({
    routes,
    mode:"hash"
});

const app = new Vue({
    el: '#app',
    router
});
