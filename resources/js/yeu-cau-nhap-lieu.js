require('./bootstrap');
window.Vue = require('vue');
Vue.component('yeu-cau-nhap-lieu', require('./components/dulieudacthu/YeuCauNhapLieu').default);
new Vue({
    el: '#app'
});
