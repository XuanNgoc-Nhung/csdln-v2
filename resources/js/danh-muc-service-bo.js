require('./bootstrap');
window.Vue = require('vue');
Vue.component('danh-muc-service-bo', require('./components/quantrihethong/DanhMucServiceBo').default);
new Vue({
    el: '#app'
});
