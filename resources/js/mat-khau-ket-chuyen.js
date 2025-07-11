require('./bootstrap');
window.Vue = require('vue');
Vue.component('mat-khau-ket-chuyen', require('./components/hethong/matKhauKetChuyen/danhSach.vue').default);
new Vue({
    el: '#app'
});
