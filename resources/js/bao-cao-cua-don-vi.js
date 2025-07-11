require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-cua-don-vi', require('./components/baocao/BaoCaoCuaDonVi').default);
new Vue({
    el: '#app'
});
