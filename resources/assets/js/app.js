
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

//"vue": "^2.1.10" version before

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;
window.VueAxios = require('vue-axios').default;
window.Axios = require('axios').default;
let AppLayout = require('./components/App.vue');


// CommonJS

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import Gate from './Gate';

Vue.prototype.$gate = new Gate(window.user);


window.Form = Form;
window.swal = Swal;
window.VueFire = new Vue();


Vue.use(VueRouter,VueAxios,Axios,VueProgressBar);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination',require('laravel-vue-pagination'));



//const Userlist = Vue.component('Userlist', require('./components/Userlist.vue') );
const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
})

window.toast = toast;

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '50px'
})

const routes = [
{	path: '/profile',
	name:'profile',
	component: require('./components/Profile')
},
/*{	path: '/home',name:'profile', component: require('./components/Profile')},*/
{	path: '/dashboard',component: require('./components/Dashboard') },
{	path: '/users',component: require('./components/Userlist.vue')},
{ path: '/developer',component: require('./components/Developer.vue')},
{ path: '/addcategories',component: require('./components/CategoryPrice.vue')},
{ path: '/pricelist',component: require('./components/Pricelist.vue')},
{ path: '*',component: require('./components/NotFound.vue')}

]

const router = new VueRouter({
	mode:'history',
 	routes: routes // short for `routes: routes`
})

Vue.filter('upText',function(text){
	return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('timeToStrFromat',function(getTime){
	return moment(getTime).format("MMM Do YY");  
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);
const app = new Vue({
  el: '#app',
  router,
  data:{
    search:'',
    dashboard:''
  },
  AppLayout,
  methods:{
    searchit: _.debounce(() =>{
      VueFire.$emit('searching');
    },2000),
    boom(){
      alert('boom');
    }
  }
});

