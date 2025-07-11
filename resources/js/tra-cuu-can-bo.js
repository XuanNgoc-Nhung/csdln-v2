require('./bootstrap');
window.Vue = require('vue');
// Vue.component('tra-cuu-danh-sach-can-bo', require('./components/tracuu/CanBoGiaoVien/DanhSach').default);
Vue.component('tra-cuu-danh-sach-can-bo', require('./components/tracuu/CanBoGiaoVien/index').default);
new Vue({
    el: '#app'
});
