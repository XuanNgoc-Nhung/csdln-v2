require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/vi'

Vue.use(ElementUI, { locale })

Vue.component('giai-the-truong', require('./components/sapnhapgiaithe/GiaiThe').default);
new Vue({
    el: '#app'
});
