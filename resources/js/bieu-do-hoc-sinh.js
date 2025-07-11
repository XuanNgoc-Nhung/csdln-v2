require('./bootstrap');
window.Vue = require('vue');
Vue.component('bieu-do-hoc-sinh', require('./components/bieudo/BieuDoHocSinh').default);
new Vue({
    el: '#app'
});
