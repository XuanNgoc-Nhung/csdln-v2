require('./bootstrap');
window.Vue = require('vue');
Vue.component('quan-ly-cau-hoi-thuong-gap', require('./components/doimatkhau/CauHoiThuongGap.vue').default);
new Vue({
    el: '#app'
});
