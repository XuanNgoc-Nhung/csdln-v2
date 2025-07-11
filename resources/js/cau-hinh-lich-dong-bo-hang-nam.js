require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-lich-dong-bo-hang-nam', require('./components/quanlydongbo/LichDongBoHangNam').default);
new Vue({
    el: '#app'
});
