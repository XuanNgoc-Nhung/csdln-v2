
require('../bootstrap');
// import BootstrapVue from 'bootstrap-vue'
window.Vue = require('vue');
// Vue.use(BootstrapVue)
Vue.component('list-user', require('../components/user_normal/DebtList.vue').default);
new Vue({
    el: '#app'
});
