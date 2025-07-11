require('./bootstrap');
window.Vue = require('vue');

Vue.component('tong-hop-du-lieu', require('./components/hethong/TongHopDuLieuTruongHoc').default);
new Vue({
    el: '#app'
});
