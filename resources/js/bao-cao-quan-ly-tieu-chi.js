require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-quan-ly-tieu-chi', require('./components/baocaodong/QuanLyTieuChi').default);
new Vue({
    el: '#app'
});
