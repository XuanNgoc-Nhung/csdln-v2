require('./bootstrap');
window.Vue = require('vue');
Vue.component('mat-khau-ket-chuyen-ioc', require('./components/hethong/matKhauKetChuyenIoc/danhSach.vue').default);
new Vue({
    el: '#app'
});
