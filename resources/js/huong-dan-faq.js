require('./bootstrap');
window.Vue = require('vue');
Vue.component('huong-dan-faq', require('./components/doimatkhau/HuongDanFaq.vue').default);
new Vue({
    el: '#huongdan'
});
