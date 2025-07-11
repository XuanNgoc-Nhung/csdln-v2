require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-danh-sach-hoc-sinh-dong-bo', require('./components/tracuu/TraCuuHocSinhDongBo').default);
new Vue({
    el: '#app'
});
