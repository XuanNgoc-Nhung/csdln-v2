require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-email', require('./components/hethong/CauHinhEmail').default);
new Vue({
    el: '#app'
});
