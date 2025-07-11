require('./bootstrap');
window.Vue = require('vue');
Vue.component('dang-nhap', require('./components/dangnhap/DangNhap').default);
new Vue({
    el: '#app'
});
