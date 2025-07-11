require('./bootstrap');
window.Vue = require('vue');
// Vue.component('yeu-cau-nop-thong-ke-theo-bieu-mau', require('./components/quantrihethong/YeuCauNopThongKeTheoBieuMau').default);
import ElementUI from 'element-ui'
import locale from './utils/custom-elementui-locale'

Vue.use(ElementUI, { locale })
Vue.component('yeu-cau-nop-thong-ke-theo-bieu-mau', require('./components/quantrihethong/nopThongKeTheoBieuMau').default);

new Vue({
    el: '#app'
});
