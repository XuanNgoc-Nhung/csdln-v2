require('./bootstrap');
window.Vue = require('vue');
Vue.component('don-vi', require('./components/danhmuc/DonVi').default);
new Vue({
    el: '#app'
});
