require('./bootstrap');
window.Vue = require('vue');
Vue.component('danh-sach-tieu-chi', require('./components/baocaodong/chinhSuaTemplateBaoCao/danhSachTieuChi').default);
new Vue({
    el: '#danhsachtieuchi'
});
