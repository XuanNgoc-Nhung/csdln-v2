require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-gui-len', require('./components/baocao/BaoCaoGuiLen').default);
new Vue({
    el: '#app'
});
