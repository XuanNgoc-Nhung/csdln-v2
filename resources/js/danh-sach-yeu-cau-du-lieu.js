require('./bootstrap');
window.Vue = require('vue');
Vue.component('danh-sach-yeu-cau-du-lieu', require('./components/quanlydongbo/DanhSachYeuCauDuLieu').default);
new Vue({
    el: '#app'
});
