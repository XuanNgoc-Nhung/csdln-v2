require('./bootstrap');
window.Vue = require('vue');
Vue.component('quan-ly-bao-cao', require('./components/baocao/quanlybaocao/QuanLyBaoCao').default);
new Vue({
    el: '#app'
});
