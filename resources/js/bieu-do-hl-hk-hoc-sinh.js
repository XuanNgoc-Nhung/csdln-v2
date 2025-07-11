require('./bootstrap');
window.Vue = require('vue');
Vue.component('bieu-do-xep-loai-hoc-sinh', require('./components/bieudo/BieuDoXepLoaiHocSinh').default);
new Vue({
    el: '#app'
});
