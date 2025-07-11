require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-lich-dong-bo-cu', require('./components/quanlydongbo/LichDongBoCu').default);
new Vue({
    el: '#app'
});
