require('./bootstrap');
window.Vue = require('vue');
Vue.component('thong-tin-y-te-hoc-sinh', require('./components/tracuu/thongTinYTe/hocSinh.vue').default);
new Vue({
    el: '#app'
});
