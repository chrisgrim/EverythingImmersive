
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

// import component and stylesheet
import AirbnbStyleDatepicker from 'vue-airbnb-style-datepicker'

import 'vue-airbnb-style-datepicker/dist/vue-airbnb-style-datepicker.min.css'

// make sure we can use it in our components
// see docs for available options
const datepickerOptions = {}

// make sure we can use it in our components
Vue.use(AirbnbStyleDatepicker, datepickerOptions)

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('likes', require('./components/likes.vue').default);
Vue.component('flash', require('./components/flash.vue').default);
Vue.component('favorite', require('./components/favorite.vue').default);
Vue.component('avatar-form', require('./components/avatar-form.vue').default);
Vue.component('profile-button', require('./components/profile-button.vue').default);
Vue.component('featured-image', require('./components/featured-image.vue').default);
Vue.component('autocomplete', require('./components/autocomplete.vue').default);
Vue.component('create-organization', require('./components/create-organization.vue').default);
Vue.component('create-location', require('./components/create-location.vue').default);
Vue.component('create-date-picker', require('./components/create-datepicker.vue').default);
Vue.component('create-details', require('./components/create-details.vue').default);
Vue.component('create-description', require('./components/create-description.vue').default);
Vue.component('create-guide', require('./components/create-guide.vue').default);
Vue.component('create-expect', require('./components/create-expect.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if(document.getElementById("app")){
    const app = new Vue({
        el: '#app'
    });
};
if(document.getElementById("navArea")){
    const navsearch = new Vue({
        el: '#navArea'
    });
};
if(document.getElementById("createContentArea")){
    const createContentArea = new Vue({
        el: '#createContentArea'
    });
};
if(document.getElementById("guide")){
    const guide = new Vue({
        el: '#guide'
    });
};
