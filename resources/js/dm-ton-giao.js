require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-ton-giao', require('./components/danhmuc/TonGiao').default);
new Vue({
    el: '#app'
});
