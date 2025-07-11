require('./bootstrap');
window.Vue = require('vue');
Vue.component('hoc-sinh-giao-vien-chuyen-truong', require('./components/ketchuyendulieu/HocSinhGiaoVienChuyenTruong.vue').default);
new Vue({
    el: '#app'
});
