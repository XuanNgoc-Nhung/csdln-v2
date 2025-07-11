require('./bootstrap');
window.Vue = require('vue');
Vue.component('chinh-sua-template-bao-cao', require('./components/baocaodong/TieuChiBaoCao/danhSachTieuChi').default);
Vue.component('danh-sach-tieu-chi-ngoai', require('./components/baocaodong/TieuChiBaoCao/danhSachTieuChiNgoai').default);
new Vue({
    el: '#myTabContent'
});