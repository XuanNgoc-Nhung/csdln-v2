
require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'

window.Vue = require('vue');
Vue.use(BootstrapVue)
Vue.component('create-role', require('./components/ListAdminUser.vue').default);
const app = new Vue({
    el: '#app'
});
