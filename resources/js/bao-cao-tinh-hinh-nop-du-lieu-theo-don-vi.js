require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-tinh-hinh-nop-du-lieu-theo-don-vi', require('./components/tiepnhandulieuqlnt/baoCaoTinhHinhNopDuLieuTheoDonVi.vue').default);
new Vue({
    el: '#app'
});
