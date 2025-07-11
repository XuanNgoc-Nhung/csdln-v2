require('./bootstrap');
window.Vue = require('vue');
// import ElementUI from 'element-ui'
// import locale from './utils/custom-elementui-locale'
// Vue.use(ElementUI, { locale })
// Đặt ngôn ngữ mặc định (ví dụ: Tiếng Việt)


Vue.component('doi-mat-khau', require('./components/doimatkhau/DoiMatKhau.vue').default);
new Vue({
    el: '#doimatkhau'
});
