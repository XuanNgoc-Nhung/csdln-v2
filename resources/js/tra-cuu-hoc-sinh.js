require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-danh-sach-hoc-sinh', require('./components/tracuu/hocsinh/index.vue').default);
new Vue({
    el: '#app'
});
