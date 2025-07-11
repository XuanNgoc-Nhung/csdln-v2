require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import locale from './utils/custom-elementui-locale'
Vue.use(ElementUI, { locale })
Vue.component('cau-hinh-lich-dong-bo', require('./components/quanlydongbo/LichDongBo').default);
new Vue({
    el: '#app'
});
