require('./bootstrap');
window.Vue = require('vue');
Vue.component('nhap-lieu-du-lieu-nam-hoc', require('./components/dulieu/nhapLieuDuLieuNamHoc').default);
new Vue({
    el: '#app'
});
