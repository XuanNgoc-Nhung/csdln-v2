require('./bootstrap');
window.Vue = require('vue');
Vue.component('nhap-lieu-du-lieu-cu', require('./components/hethong/duLieuNamHocCu/nhapLieu').default);
new Vue({
    el: '#app'
});
