require('./bootstrap');
window.Vue = require('vue');
// Vue.component('dashboard', require('./components/bieudo/DashBoard').default);
Vue.component('dashboard', require('./components/bieudo/Dasboard2').default);
new Vue({
    el: '#app'
});
