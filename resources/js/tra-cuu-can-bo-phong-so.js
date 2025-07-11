require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-danh-sach-can-bo-phong-so', require('./components/tracuu/TraCuuCanBoPhongSo').default);
new Vue({
    el: '#app'
});
