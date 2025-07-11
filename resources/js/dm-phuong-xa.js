require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-phuong-xa', require('./components/danhmuc/PhuongXa/Index').default);
new Vue({
    el: '#app'
});
