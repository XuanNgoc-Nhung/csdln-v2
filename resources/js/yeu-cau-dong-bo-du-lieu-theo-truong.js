require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import locale from './utils/custom-elementui-locale'

Vue.use(ElementUI, { locale })
Vue.component('yeu-cau-dong-bo-du-lieu-theo-truong', require('./components/quanlydongbo/YeuCauDuLieuTheoTruong').default);
new Vue({
    el: '#app'
});
