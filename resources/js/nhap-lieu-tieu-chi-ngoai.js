require('./bootstrap');
window.Vue = require('vue');
Vue.component('nhap-lieu-tieu-chi-ngoai', require('./components/baocaodong/TieuChiBaoCao/nhapLieuTieuChiNgoai.vue').default);
new Vue({
    el: '#app'
});
