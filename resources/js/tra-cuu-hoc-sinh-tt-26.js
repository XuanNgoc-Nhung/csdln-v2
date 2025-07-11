require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-hoc-sinh-tt-26', require('./components/tracuu/hocsinh/thongTu26').default);
new Vue({
    el: '#app'
});
