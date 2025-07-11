require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-mau-email', require('./components/hethong/CauHinhMauEmail').default);
new Vue({
    el: '#app'
});
