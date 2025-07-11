require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui';
Vue.use(ElementUI);

Vue.component('cau-hinh-duyet-day-du-lieu', require('./components/cauhinhduyetdaydulieu/CauHinhDuyetDay').default);
new Vue({
    el: '#app'
});
