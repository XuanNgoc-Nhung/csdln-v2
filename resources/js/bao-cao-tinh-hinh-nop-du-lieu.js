require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-tinh-hinh-nop-du-lieu', require('./components/tiepnhandulieuqlnt/baoCaoTinhHinhNopDuLieu.vue').default);
new Vue({
    el: '#app'
});
