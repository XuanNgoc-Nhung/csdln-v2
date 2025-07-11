require('./bootstrap');
window.Vue = require('vue');
Vue.component('nop-du-lieu-sso', require('./components/quantrihethong/LichSuChuyenDuLieu/index.vue').default);
new Vue({
    el: '#app'
});
