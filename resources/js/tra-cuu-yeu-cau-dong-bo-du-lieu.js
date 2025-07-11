require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-yeu-cau-dong-bo', require('./components/quanlydongbo/TraCuuYeuCauDongBo').default);
new Vue({
    el: '#app'
});
