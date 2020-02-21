require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = true;
Vue.config.performance = true;

import App from './App.vue';

//Route
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { routes } from './routes';

const router = new VueRouter({
  routes, 
  mode: 'hash',

})

import '../../node_modules/bootstrap/dist/css/bootstrap.min.css';

const app = new Vue({
  el: '#app',
  router,
  render: h => h(App)
});