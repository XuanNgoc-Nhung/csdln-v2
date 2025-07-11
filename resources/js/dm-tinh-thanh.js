require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-tinh-thanh', require('./components/danhmuc/TinhThanh').default);
new Vue({
    el: '#app'
});
