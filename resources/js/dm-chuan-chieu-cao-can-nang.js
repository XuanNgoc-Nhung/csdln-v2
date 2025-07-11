require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-chuan-chieu-cao-can-nang', require('./components/danhmuc/ChuanChieuCaoCanNang').default);
new Vue({
    el: '#app'
});
