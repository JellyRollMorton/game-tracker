/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./select2.min');

window.Vue = require('vue');

import VueBus from 'vue-bus';

Vue.use(VueBus);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('add-game-modal', require('./components/AddGameModalComponent.vue'));
Vue.component('add-player-modal', require('./components/AddPlayerModalComponent.vue'));
Vue.component('dashboard', require('./components/DashboardComponent.vue'));

const app = new Vue({
    el: '#app'
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});