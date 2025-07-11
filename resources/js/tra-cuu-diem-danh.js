require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-diem-danh', require('./components/tracuu/diemDanh/index').default);

new Vue({
    el: '#app'
});
