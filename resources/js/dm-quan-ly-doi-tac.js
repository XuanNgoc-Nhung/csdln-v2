require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-quan-ly-doi-tac', require('./components/danhmuc/QuanLyDoiTac').default);
new Vue({
    el: '#app'
});
