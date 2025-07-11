require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-chuyen-nganh-dao-tao', require('./components/danhmuc/ChuyenNganhDaoTao').default);
new Vue({
    el: '#app'
});
