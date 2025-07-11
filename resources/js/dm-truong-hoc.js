require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-truong-hoc', require('./components/danhmuc/truongHoc/TruongHoc').default);
new Vue({
    el: '#app'
});
