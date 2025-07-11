require('./bootstrap');
window.Vue = require('vue');
Vue.component('yeu-cau-dong-bo-du-lieu-cu', require('./components/quanlydongbo/YeuCauDongBoDuLieuCu').default);
new Vue({
    el: '#app'
});
