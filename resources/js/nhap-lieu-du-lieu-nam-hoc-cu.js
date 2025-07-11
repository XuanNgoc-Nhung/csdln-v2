require('./bootstrap');
window.Vue = require('vue');
Vue.component('nhap-lieu-du-lieu-nam-hoc-cu', require('./components/dulieu/nhapLieuDuLieuNamHocCu').default);
new Vue({
    el: '#app'
});
