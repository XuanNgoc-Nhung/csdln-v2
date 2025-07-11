require('./bootstrap');
window.Vue = require('vue');
Vue.component('bieu-do-giao-vien', require('./components/bieudo/BieuDoGiaoVien').default);
new Vue({
    el: '#app'
});
