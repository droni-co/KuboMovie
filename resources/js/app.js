/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import Vuetify from 'vuetify';
Vue.use(Vuetify);
import VueRouter from 'vue-router'
Vue.use(VueRouter)



// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.


Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('movie-card-component', require('./components/MovieCardComponent.vue').default);

// Sections
import Home from './components/HomeComponent';
import Category from './components/CategoryComponent';
import Movie from './components/MovieComponent';
import CreateMovie from './components/CreateMovieComponent';
const routes = [
  { path: '/', component: Home },
  { path: '/categories/:id', component: Category },
  { path: '/movie/create', component: CreateMovie },
  { path: '/movie/:id', component: Movie }
]

const router = new VueRouter({
  routes // short for `routes: routes`
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  router,
  data: () => ({ drawer: null }),
  vuetify: new Vuetify({
    theme: {
      themes: {
        light: {
          primary: '#264488', // #E53935
          secondary: '#00979D', // #FFCDD2
        },
      },
    }
  }),
});
