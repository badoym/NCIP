/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueSimpleAlert from "vue-simple-alert";
import { ClientTable } from 'vue-tables-2';

Vue.use(ClientTable, {}, false, 'bootstrap4');
Vue.use(VueSimpleAlert);
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
Vue.component('home-component', require('./components/HomeComponent.vue').default);
Vue.component('regions-component', require('./components/masterdata/RegionComponent.vue').default);
Vue.component('provinces-component', require('./components/masterdata/ProvinceComponent.vue').default);
Vue.component('cities-component', require('./components/masterdata/CityComponent.vue').default);
Vue.component('barangay-component', require('./components/masterdata/BarangayComponent.vue').default);
Vue.component('government-program-component', require('./components/masterdata/GovernmentProgramComponent.vue').default);
Vue.component('services-component', require('./components/masterdata/ServicesComponent.vue').default);
Vue.component('indigenous-group-component', require('./components/masterdata/IndigenousGroupComponent.vue').default);
Vue.component('user-component', require('./components/masterdata/UserComponent.vue').default);
Vue.component('program-services-opening-component', require('./components/main/ProgamAndServicesOpeningComponent.vue').default);
Vue.component('indigenous-people-masterlist-component', require('./components/main/IndigenousPeopleMasterlistComponent.vue').default);


// web users components
Vue.component('web-users-services-component', require('./components/webusers/ServicesComponent.vue').default);
Vue.component('profile-information-component', require('./components/webusers/ProfileInformation.vue').default);
Vue.component('web-user-govprograms-component', require('./components/webusers/GovernmentProgramComponent.vue').default);
Vue.component('chat-component', require('./components/webusers/ChatComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
