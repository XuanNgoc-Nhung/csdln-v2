require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-mon-hoc', require('./components/danhmuc/MonHoc').default);
new Vue({
    el: '#app'
});
