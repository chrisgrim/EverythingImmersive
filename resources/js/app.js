
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */




require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();
window.flash = function (message) {
	window.events.$emit('flash', message);
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('likes', require('./components/likes.vue').default);
Vue.component('favorite', require('./components/favorite.vue').default);
Vue.component('avatar-form', require('./components/avatar-form.vue').default);
Vue.component('profile-button', require('./components/profile-button.vue').default);
Vue.component('featured-image', require('./components/featured-image.vue').default);
Vue.component('autocomplete', require('./components/autocomplete.vue').default);
Vue.component('organizationautocomplete', require('./components/organizationAutocomplete.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

const navsearch = new Vue({
    el: '#navArea'
});

const orgAutoComplete = new Vue({
    el: '#orgAutoComplete'
});
