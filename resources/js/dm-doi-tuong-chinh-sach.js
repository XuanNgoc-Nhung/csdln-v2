require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-doi-tuong-chinh-sach', require('./components/danhmuc/DoiTuongChinhSach').default);
new Vue({
    el: '#app'
});
