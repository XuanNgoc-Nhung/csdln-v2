require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-loai-doi-tuong', require('./components/danhmuc/LoaiDoiTuong').default);
new Vue({
    el: '#app'
});
