require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-nhom-tieu-chi', require('./components/baocaodong/BaoCaoNhomTieuChi').default);
new Vue({
    el: '#app'
});
