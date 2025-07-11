require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-duong-dan-logo', require('./components/hethong/CauHinhDuongDanLogo').default);
new Vue({
    el: '#app'
});
