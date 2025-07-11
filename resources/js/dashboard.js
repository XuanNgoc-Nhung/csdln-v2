require('./bootstrap');
window.Vue = require('vue');
// Vue.component('dashboard', require('./components/bieudo/DashBoard').default);
Vue.component('dashboard', require('./components/bieudo/DashBoard3').default);
new Vue({
    el: '#app'
});
