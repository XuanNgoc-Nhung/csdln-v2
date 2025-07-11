require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-quan-huyen', require('./components/danhmuc/QuanHuyen/index').default);
new Vue({
    el: '#app'
});
