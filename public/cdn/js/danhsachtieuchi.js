require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-danh-sach-can-bo', require('./components/tracuu/TraCuuCanBo').default);
new Vue({
    el: '#danhsachtieuchi'
});
