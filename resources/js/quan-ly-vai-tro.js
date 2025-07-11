require('./bootstrap');
window.Vue = require('vue');
Vue.component('quan-ly-vai-tro', require('./components/hethong/quanLyVaiTro/index').default);
new Vue({
    el: '#app'
});
