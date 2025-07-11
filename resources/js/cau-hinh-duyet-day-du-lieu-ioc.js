require('./bootstrap');
window.Vue = require('vue');
Vue.component('cau-hinh-duyet-day-du-lieu-ioc', require('./components/cauhinhduyetdaydulieuioc/CauHinhDuyetDay').default);
new Vue({
    el: '#app'
});
