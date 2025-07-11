require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import locale from './utils/custom-elementui-locale'

Vue.use(ElementUI, { locale })
Vue.component('nop-du-lieu', require('./components/dulieu/nopDuLieu').default);
new Vue({
    el: '#app'
});
