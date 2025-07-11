require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-dong', require('./components/baocaodong/BaoCaoDong').default);
new Vue({
    el: '#app'
});
// import Vue from 'vue';
// import App from './components/baocaodong/BaoCaoDong';

// Vue.config.productionTip = false;

// new Vue({
//   render: h => h(App),
// }).$mount('#app');


