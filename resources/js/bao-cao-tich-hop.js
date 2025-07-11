require('./bootstrap');
window.Vue = require('vue');

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/vi'

Vue.use(ElementUI, { locale })

Vue.component('bao-cao-tich-hop', require('./components/baocao/BaoCaoTichHop').default);
new Vue({
    el: '#app'
});
// import Vue from 'vue';
// import App from './components/baocaodong/BaoCaoDong';

// Vue.config.productionTip = false;

// new Vue({
//   render: h => h(App),
// }).$mount('#app');


