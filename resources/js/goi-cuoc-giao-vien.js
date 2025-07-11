require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/vi'

Vue.use(ElementUI, { locale })

Vue.component('goi-cuoc-giao-vien', require('./components/hethong/goiCuocGiaoVien').default);
new Vue({
    el: '#app'
});
