require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-tieu-chi', require('./components/baocaodong/baoCaoDongPhuongAnV2/DanhSach.vue').default);
new Vue({
    el: '#app'
});
