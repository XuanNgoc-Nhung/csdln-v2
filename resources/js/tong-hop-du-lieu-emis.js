require('./bootstrap');
window.Vue = require('vue');

Vue.component('tong-hop-du-lieu-emis', require('./components/hethong/TongHopDuLieuTruongHocEmis').default);
new Vue({
    el: '#app'
});
