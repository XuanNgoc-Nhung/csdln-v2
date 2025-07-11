require('./bootstrap');
window.Vue = require('vue');
Vue.component('ket-chuyen-du-lieu', require('./components/hethong/KetChuyenDuLieu.vue').default);
new Vue({
    el: '#app'
});
