require('./bootstrap');
window.Vue = require('vue');
Vue.component('trang-chu-ioc-ban-do', require('./components/ioc/tongQuanBanDo').default);
new Vue({
    el: '#app'
});
