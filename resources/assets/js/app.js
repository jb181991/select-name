
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueSimpleAlert from "vue-simple-alert";
import { BootstrapVue, ModalPlugin } from 'bootstrap-vue';
import Vuelidate from 'vuelidate'

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(VueSimpleAlert);
Vue.use(BootstrapVue);
Vue.use(ModalPlugin);
Vue.use(Vuelidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('select2', require('./components/Select2.vue'));

const app = new Vue({
    el: '#app'
});
